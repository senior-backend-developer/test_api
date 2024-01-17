FROM nginx:latest

COPY docker/nginx/image-files/ /

#RUN chmod 700 \
#        /usr/local/bin/docker-entrypoint.sh
#
#ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

EXPOSE 80
EXPOSE 8880
EXPOSE 8881
CMD ["nginx", "-g", "daemon off;"]
