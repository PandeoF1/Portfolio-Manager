# [Portfolio - Manager](https://portfolio-demo.pandeo.fr)
> Small work for the school of P.Clement

## File :<br />
> - [config](https://github.com/PandeoF1/Portfolio-Manager/tree/main/config) -> Configuration file <br />
> - [css](https://github.com/PandeoF1/Portfolio-Manager/tree/main/css) -> CSS file <br />
> - [js](https://github.com/PandeoF1/Portfolio-Manager/tree/main/js) -> JS file (Jquery & canvajs) <br />
> - [sql](https://github.com/PandeoF1/Portfolio-Manager/tree/main/sql) -> SQL file (Database template) <br />
> - [index.php](https://github.com/PandeoF1/Portfolio-Manager/blob/main/index.php) -> website (All in one)<br />

## Apache Configuration File :
```` 
<VirtualHost *:80>
        <Directory /var/www/Portfolio-Manager/>
              Options Indexes FollowSymLinks MultiViews
               AllowOverride All
               Require all granted
        </Directory>

        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/Portfolio-Manager/
        ServerName domain
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
````
## Requirements :
 > - apache <br />
 > - mysql/mariadb <br />
 > - php (xml / mysqli)<br />
