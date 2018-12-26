# Ir URL
Sistema acortador de URLs, permite la protección del URL mediante contraseña. Además permite llevar un registro de los accesos al URL acortado.

# Documentación
## Instalación del Proyecto
* Instalar con Composer
```bash
composer install
```
* Modificar el Archivo **.env** con sus configuraciones.
* Realizar las migraciones en la Base de Datos
```bash
php artisan migrate
```
* Crear servidor
```bash
php -S localhost:8000 -t public
```
* Listo 🙂 [DEMO](https://ir.nstreri.ga/)

## Endpoints API HTTP
### Crear URL Acortada
**URL**: `api/urls`
**Método**: `POST`
**Cuerpo**: `JSON`
```json
{
  "url": "URL_A_ACORTAR",
  "pass" : "PASSWORD" or null
}
```
**Respuesta**: `JSON`
```json
{
	"url": "URL_ACORTADA",
	...
	"fullUrl": "http://localhost:8000/SHORTCODE",
	"shortCode": "CODIDO ACORTADO ASIGNADO"
}
```
**Códigos de Estado**:
- 201: Creado con Exito
- 422: Si los datos no son correcto. Se retorna JSON con lista de errores.

### Ver URL Acortada
**URL**: `api/urls/{CODIDO_ACORTADO_ASIGNADO}?pass=CLAVE_DE_PROTECCION`
**Método**: `GET`

**Respuesta**: `JSON`
```json
{
	"url": "URL_ACORTADA",
	...
	"fullUrl": "http://localhost:8000/SHORTCODE",
	"shortCode": "CODIDO ACORTADO ASIGNADO"
}
```
**Códigos de Estado**:
- 200: Solicitud con exito
- 401: Contraseña incorrecta/Solicitud de Contraseña
- 404: La URL Acortada no existe

**Nota**: `?pass=` solo si se creó con Contraseña. Este endpoint registra el acceso como estadística.

### Ver estadísticas URL Acortada
**URL**: `api/urls/{CODIDO_ACORTADO_ASIGNADO}/statistics/{type}?pass=CLAVE_DE_PROTECCION`
**Método**: `GET`

**Parámetro type**: Valores posibles
- `hour`: Estadísticas desde una Hora antes a la Solicitud HTTP
- `day`
- `week`
- `month`
- `year`

**Respuesta**: `JSON`
```json
{
	"total_accesses": NUMERO_DE_ACCESOS_TOTALES,
	"countries": [
		{
			"country": "AR",
			"cant": "NUMERO_TOTAL"
		},
		...
	],
	"os": [
		{
			"os": "Linux",
			"cant": "NUMERO_TOTAL"
		},
		...
	],
	"browsers": [
		{
			"browser": "Chrome",
			"cant": "NUMERO_TOTAL"
		},
		...
	],
	"devices": [
		{
			"device": "COMPUTER",
			"cant": "NUMERO_TOTAL"
		},
		...
	]
}
```
**Códigos de Estado**:
- 200: Solicitud con exito
- 401: Contraseña incorrecta/Solicitud de Contraseña
- 404: La URL Acortada no existe

## Datos recopilados por las estadísticas
Las estadísticas incluyen información de:
* IP del Visitante
* Navegador
* Dispositivo (Tablet, PC o Movil)
* Sistema Operativo
* Cantidad total de Clicks
* País de procedencia

**Nota:** El país de procedencia se obtiene desde el Header "HTTP_CF_IPCOUNTRY" agregado por la Red [Cloudflare](https://www.cloudflare.com).
Para modificar la forma de obtener el país ver `Helpers@getCodeCountry()` en `app/Libraries/Helpers.php`.

# Notas
El proyecto fue realizado y probado utilizando:
* PHP 7.1
* 10.1.31-MariaDB - MariaDB Server

El proyecto puede contener errores, si encuentra alguno no dude en informarlo.