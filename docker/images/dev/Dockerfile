FROM phpbase

RUN yum -y --setopt=tsflags=nodocs --nogpgcheck install openssl git mysql

WORKDIR /srv

COPY wait-for-mariadb.sh /srv
RUN chmod +x /srv/wait-for-mariadb.sh

WORKDIR /srv/app

COPY init.sh /srv/init.sh
RUN chmod +x /srv/init.sh

RUN yum -y --setopt=tsflags=nodocs --nogpgcheck install wget

RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN export PATH="$HOME/.symfony/bin:$PATH"

CMD /srv/init.sh