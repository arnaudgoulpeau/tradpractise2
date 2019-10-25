FROM centos:7

RUN yum -y --setopt=tsflags=nodocs update && \
    yum -y --setopt=tsflags=nodocs --nogpgcheck install epel-release && \
    yum -y --setopt=tsflags=nodocs --nogpgcheck install https://centos7.iuscommunity.org/ius-release.rpm && \
    yum -y --setopt=tsflags=nodocs --nogpgcheck install unzip epel-release && \
    yum -y --setopt=tsflags=nodocs --nogpgcheck install php72u-cli \
        php72u-intl \
        php72u-json \
        php72u-mbstring \
        php72u-opcache \
        php72u-pdo \
        php72u-pear  \
        php72u-pecl-apcu \
        php72u-mysqlnd \
        php72u-soap \
        php72u-tidy \
        php72u-xml \
        nodejs && \
        yum clean all

RUN curl --silent --location https://dl.yarnpkg.com/rpm/yarn.repo | tee /etc/yum.repos.d/yarn.repo
RUN yum -y --setopt=tsflags=nodocs --nogpgcheck install yarn

RUN echo "date.timezone = \"Europe/Paris\"" > /etc/php.d/timezone.ini \
    && echo "memory_limit=4096M" > /etc/php.d/memory.ini \
    && echo "intl.default_locale = fr_FR" >> /etc/php.d/intl.ini \
    && echo "realpath_cache_size=4096K" >> /etc/php.d/sf.ini \
    && echo "realpath_cache_ttl=600" >> /etc/php.d/sf.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /srv/app