# Concept

Originally, Froxlor is designed to work on a single host running all required services (webserver, database,
 mail server, FTP, DNS, ...). Froxlor-MN ("multi-node") tries to extend Froxlor so we can have multiple nodes 
 (workers) for different purposes.
 
Currently, we have split out the services to the following nodes (all realized with Docker):

1. central instance: running Froxlor, Mailserver, FTP Server
2. MySQL instances: one DB instance for Froxlor, 1..n instances for customers
3. 1..n worker nodes which serve http(s) requests

Customer data (`/var/customers`) is kept in a central directory which gets mounted to all nodes, so all nodes
 have access to the same data.
  
# Config generation 
Since Froxlor is not running on the worker nodes, we have to mount the necessary folders of the workers to 
subdirectories on the central instance:
  
```bash
# first worker
worker1:/etc/apache2/sites-enabled/ => froxlor:/etc/nodes/worker1/sites/
worker1:/etc/php5/fpm/pool.d/ => froxlor:/etc/nodes/worker1/pools/
# second worker
worker2:/etc/apache2/sites-enabled/ => froxlor:/etc/nodes/worker2/sites/
worker1:/etc/php5/fpm/pool.d/ => froxlor:/etc/nodes/worker2/pools/
...
```
 
# Limitations

Currently we only support the following stances:

* OS: Debian/Ubuntu w/ Apache >= 2.4.9 (we use mod_proxy_fcgi)
* Webserver: Apache
* Mailserver: Postfix / Dovecot
* PHP: FPM worker 

# Installation

froxlor-mn uses Doctrine, which must be installed through Composer into vendor/doctrine:

```bash
php composer.phar install
```
 
# TODO:

* actually generate the config in the right directories
* find a way to tell the workers that the config has changed
* test what happens when we restart the db server (see https://github.com/docker/docker/issues/3155)