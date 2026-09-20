FROM nginx
COPY ./ /usr/share/nginx/html

# Expose port 80 (default Apache port)
EXPOSE 80
