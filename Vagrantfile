# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
 
   config.ssh.username = "vagrant"
   config.ssh.password = "vagrant"
   config.vm.box = "scotch/box"
   config.vm.box_version = "2.5"
   config.vm.network "private_network", ip: "192.168.33.10"
   config.vm.hostname = "scotchbox"
   config.vm.synced_folder ".", "/var/www", :mount_options => ["dmode=777", "fmode=666"]
 
end 