#!/usr/bin/env sh


# Host + Port parameters required for setting up the WordPress site
Host=${1?Host required}
Port=${2?Port required}


# Wait until WordPress container became ready
# See also https://github.com/wp-cli/wp-cli/issues/4106 .
until sleep 2s ; docker-compose exec wordpress \
  sudo -u www-data \
    wp db check > /dev/null
do
  echo "Waiting for WordPress container becoming ready..."
done
echo "WordPress container ready."

# Finish installation
# TODO: Agnostic url?
docker-compose exec wordpress \
  sudo -u www-data \
    wp core install \
      --skip-email \
      --path=/var/www/html \
      --skip-email \
      --url=$Host:$Port \
      --title="Example site" \
      --admin_user=admin \
      --admin_password="test" \
      --admin_email=info@example.com

# Improve blog description
docker-compose exec wordpress \
  sudo -u www-data \
    wp option update \
      --path=/var/www/html \
        blogdescription 'Example site for Twenty Seventeen One Page Child Theme'

# Install plugin for smooth scrolling to anchors
# Note: wp-content/plugins is owned and only writable by root
docker-compose exec wordpress \
  wp plugin install \
      --allow-root \
      --path=/var/www/html \
      --activate \
      jquery-smooth-scroll \

# Activate this theme (One Page additions for Twenty Seventeen)
docker-compose exec wordpress \
  sudo -u www-data \
    wp theme activate twentyseventeen-onepage


# Populate with additional 4x example pages
# TODO: Make idempotent.
docker-compose exec wordpress \
  sudo -u www-data bash -c ' \
    curl http://loripsum.net/api/5 | \
    wp post generate \
      --path=/var/www/html \
      --post_date=2017-05-30 \
      --post_type=page \
      --count=4 \
      --post_content
    '

# Use more descriptive slugs for pages
# 3-6
for id in $(seq 3 6); do 
  no=$(($id - 2)) && \
  docker-compose exec wordpress \
    sudo -u www-data \
      wp post update "$id" \
        --post_name="page-$no"
done



# Set front page options
docker-compose exec wordpress \
  sudo -u www-data bash -c '\
    wp option update \
      --path=/var/www/html \
        show_on_front page \
 && wp option update \
      --path=/var/www/html \
        page_on_front 2 \
  '

# Assign extra examples pages to front page (Twenty Seventeen specific)
docker-compose exec wordpress \
  sudo -u www-data \
    wp option update \
      --path=/var/www/html \
      --format=json \
        theme_mods_twentyseventeen-onepage \
        '{"custom_css_post_id":-1,"panel_1":3,"panel_2":4,"panel_3":5,"panel_4":6}'


# Add primary menu
# TODO: Avoid error when menu already exists.
docker-compose exec wordpress \
  sudo -u www-data \
    wp menu create \
      --path=/var/www/html \
      'Main'

# Assign main menu to primary navigation
docker-compose exec wordpress \
  sudo -u www-data \
    wp menu location assign \
      --path=/var/www/html \
      'Main' \
      top

# Add page menu items to page anchors to menu
# TODO: Make idempotent.
docker-compose exec wordpress \
  sudo -u www-data bash -c ' \
    wp menu item add-custom Main "Sample Page" "#sample-page" \
&&  wp menu item add-custom Main "Page 1"      "#page-1" \
&&  wp menu item add-custom Main "Page 2"      "#page-2" \
&&  wp menu item add-custom Main "Page 3"      "#page-3" \
&&  wp menu item add-custom Main "Page 4"      "#page-4" \
  '

echo "Setup completed, you should now be able to visit the example site on  http://$Host:$Port".