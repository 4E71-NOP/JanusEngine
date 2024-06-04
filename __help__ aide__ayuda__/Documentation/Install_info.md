
# Installation d'un environnement



# Dans les DBs


## Mysql/MariaDB
```sql
CREATE USER `dbadmin`@`%` IDENTIFIED BY 'nimdabd';
CREATE USER `dbadmin`@`localhost` IDENTIFIED BY 'nimdabd';
GRANT ALL PRIVILEGES ON *.* TO `dbadmin`@`%`; 
GRANT ALL PRIVILEGES ON *.* TO `dbadmin`@`localhost`;
```

## Postgres

Se connecter avec l'utilisateur ```docker```. Ajouter les utilisateurs/roles ```dbadmin``` avec l'option superuser.

Créer la DB <myDb> (Par défaut 'Hdr').




# Fichiers


PHP var écrire les sessions dans ```/var/www/sessions``` d'après sa configuration (session.save_path). Ce répertoire se trouve dans ```<monDockerCompose>/_data/www/sessions/```

Le docker/php doit pouvoir écrire dans ce répertoire. Si en plus c'est monté sur un filer/NAS; ne pas trop hésiter... Un bon ```CHMOD 777``` des familles fera l'affaire.


```sh
drwxrwxr-x 1 faust users  38 13 janv. 10:28 .
drwxrwxr-x 1 faust users  58 13 janv. 10:28 ..
lrwxrwxrwx 1 faust users  58 15 mai   18:21 html -> <myData>
drwxrwxr-x 1 faust users 136 13 janv. 10:28 htmlOld
drwxrwxrWx 1 faust users  74 15 mai   20:52 sessions
```



