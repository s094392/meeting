# For Gitlab Builder
FROM fedora

RUN dnf upgrade -y
RUN dnf install -y git nodejs php composer unzip
RUN curl --silent --location https://dl.yarnpkg.com/rpm/yarn.repo | tee /etc/yum.repos.d/yarn.repo
RUN dnf install -y yarn

ENV COMPOSER_ALLOW_SUPERUSER 1 
