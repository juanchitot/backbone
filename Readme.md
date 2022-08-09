CREATE USER `backbone`@`%` IDENTIFIED BY 'backbone'
CREATE USER `backbone`@`localhost` IDENTIFIED BY 'backbone'

GRANT ALL PRIVILEGES ON backbone.* TO ‘backbone’@’localhost’;
GRANT ALL PRIVILEGES ON backbone.* TO ‘backbone’@’%’;
