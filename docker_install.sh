#!/bin/bash
shopt -s extglob

apt update -y
apt install -y apt-transport-https ca-certificates curl gnupg-agent software-properties-common
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | apt-key add -
add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
apt update
apt-cache policy docker-ce
apt install docker-ce
usermod -aG docker ${USER}

echo "Docker install complete. Logout and re-login to start using docker"