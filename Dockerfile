# For Gitlab Builder
FROM fedora

RUN dnf upgrade -y
RUN dnf install -y git nodejs php composer unzip

ENV COMPOSER_ALLOW_SUPERUSER 1 
