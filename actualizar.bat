@echo off
rem Actualizar sgf_claro
rem --------------------

if ""%1"" == """" goto vacio
@echo on
git add .
git commit -m %1
git push origin main
@echo off
goto fin

:vacio
echo "No ha colocado un mensaje de actualizacion."
goto fin

:fin