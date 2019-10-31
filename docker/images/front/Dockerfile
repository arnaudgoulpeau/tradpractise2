# base image
FROM node:12.2.0-alpine

# set working directory
WORKDIR /app

COPY docker/images/front/init.sh /srv/init.sh
RUN chmod +x /srv/init.sh

# add `/app/node_modules/.bin` to $PATH
ENV PATH /app/node_modules/.bin:$PATH

# install and cache app dependencies
COPY front/package.json /app/package.json

RUN npm install react-scripts@3.0.1 -g --silent
RUN npm install --global webpack webpack-dev-server

CMD /srv/init.sh
