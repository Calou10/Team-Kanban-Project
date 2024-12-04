FROM php:8.0-apache

# Install MySQLi extension
RUN docker-php-ext-install mysqli

# Set environment variables for the document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html

# Enable mod_rewrite for clean URLs (optional, depending on your app's requirements)
RUN a2enmod rewrite

# Copy your PHP application into the Apache web server's document root
COPY ./public /var/www/html

# Set proper permissions for Apache to access the files
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Ensure Apache is using the correct document root (optional, if the default is incorrect)
RUN echo "DocumentRoot ${APACHE_DOCUMENT_ROOT}" > /etc/apache2/sites-available/000-default.conf

# Expose port 80 for the web server
EXPOSE 80

# Start Apache when the container starts
CMD ["apache2-foreground"]