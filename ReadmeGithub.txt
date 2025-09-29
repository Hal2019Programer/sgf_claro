# Verificar que todo esta sincronizado
git remote -v
git status

#Actualizar GitHub desde tu repositorio local
git add .
git commit -m "Descripción de los cambios"
git push origin main

#Si hay cambios en GitHub que localmente no tengo, primero se hace
git pull origin main
#Luego hacer de nuevo
git add .
git commit -m "Descripción de los cambios"
git push origin main

#Crear copia de GitHub en maquina local
git clone https://github.com/usuario/repositorio.git

#Traer cambios de GitHub a repositorio local
git pull origin main

#Para subir de nuevo los cambios locales a GitHub
git add .
git commit -m "Cambios realizados"
git push origin main

