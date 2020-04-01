#!/bin/bash
shopt -s extglob

yum update -y
yum install -y yum-utils device-mapper-persistent-data lvm2

yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo
yum update -y
yum install -y docker-ce
systemctl start docker
systemctl enable docker
usermod -aG docker $USER

echo "Docker install complete. Logout and re-login to start hacking with docker." 