# Los Cuadros de Rita 🎨

**E-commerce para la Artista Peruana Rita Cam**

Un proyecto real de tienda online que sirve como galería de exposición y venta de cuadros, desarrollado con PHP7, MySQL y Bootstrap 5.

## 📋 Descripción del Proyecto

Este proyecto consiste en un e-commerce completo para la artista peruana Rita Cam, donde se puede conocer sobre la artista y funciona como galería de exposición y venta de sus obras de arte.

### 🔗 Repositorio
**URL:** https://github.com/Yucsan/PHP_Web_Tienda_Rita

### 👨‍💻 Desarrollador
**Fernando Yucsan Chang Cam**  
*Módulo: Desarrollo Backend con PHP7 y MySQL*

## 🚀 Características Principales

### **Frontend**
- ✅ Diseño responsive con Bootstrap 5
- ✅ Slider principal dinámico con Swiper.js
- ✅ Sistema de búsqueda funcional
- ✅ Carrito de compras con JavaScript y SessionStorage
- ✅ Sistema de "Me Gusta" con fetch API
- ✅ Registro y login de usuarios
- ✅ Recuperación de contraseñas
- ✅ Perfil de usuario editable
- ✅ Sistema de mensajes/comentarios
- ✅ Paginación dinámica
- ✅ Proceso completo de compra

### **Backend/Dashboard**
- ✅ Panel de administración completo
- ✅ Gestión de usuarios (CRUD)
- ✅ Gestión de productos (CRUD)
- ✅ Sistema de ordenamiento visual de productos (Drag & Drop)
- ✅ Gestión de pedidos
- ✅ Sistema de mensajes
- ✅ Gráficos con Chart.js
- ✅ Validaciones y seguridad

## 🛠️ Tecnologías Utilizadas

### **Frontend**
- **HTML5 & CSS3**
- **Bootstrap 5 Beta**
- **JavaScript ES6**
- **Swiper.js** - Slider principal
- **SweetAlert2** - Alertas personalizadas

### **Backend**
- **PHP 7**
- **MySQL**
- **Bootstrap 4.6** (Dashboard)
- **jQuery & jQuery UI**
- **Chart.js** - Gráficos estadísticos

### **Funcionalidades JavaScript**
- Fetch API para likes y eliminaciones
- SessionStorage para carrito de compras
- jQuery UI Sortable para ordenamiento
- Validaciones en tiempo real

## 📱 Funcionalidades Detalladas

### **Sistema de Usuario**
- **Registro simplificado**: Solo datos esenciales + verificación por email
- **Login con recordar sesión**: Cookie de 2 años
- **Recuperación de contraseña**: Vía email con enlaces únicos
- **Perfil editable**: Cambio de datos, foto, contraseña y dirección

### **Carrito de Compras**
- **Gestión con JavaScript**: Añadir/eliminar productos dinámicamente
- **Persistencia**: SessionStorage para navegación entre páginas
- **Validaciones**: No permite cantidades negativas
- **Pedidos guardados**: Sistema de guardado automático

### **Sistema de Likes**
- **Funcionalidad real**: Conectado a base de datos vía fetch API
- **Filtrado inteligente**: Usando `array_key_exists`
- **Solo usuarios logueados**: LocalStorage para usuarios no registrados

### **Proceso de Compra**
- **Dirección dinámica**: Solo solicita dirección al momento de compra
- **Métodos de pago**: Tarjeta (simulado) y contra entrega
- **Confirmaciones**: Email automático al finalizar pedido
- **Estados de pedido**: Guardado, en ruta, pagado

### **Panel de Administración**
- **Dashboard estadístico**: Gráficos de productos más gustados
- **Gestión completa de usuarios**: Activar/desactivar cuentas
- **Ordenamiento visual**: Drag & drop para orden de productos
- **Gestión de mensajes**: Responder consultas de usuarios

## 🗄️ Estructura de Base de Datos

El proyecto incluye múltiples tablas para:
- **Usuarios**: Datos personales, direcciones, estados
- **Productos**: Información completa, orden personalizable
- **Pedidos**: Historial completo de compras
- **Likes**: Sistema de favoritos por usuario
- **Mensajes**: Chat/consultas sobre productos
- **Contenido**: Biografía y textos dinámicos

## 🎯 Características Destacadas

### **Paginación Dinámica**
- Cálculo automático de páginas (8 productos por página)
- Navegación responsive
- Búsqueda integrada con paginación

### **Sistema de Ordenamiento**
- **Drag & Drop**: jQuery UI Sortable
- **Actualización en tiempo real**: Modifica orden sin afectar funcionalidades
- **Responsive**: Compatible con móviles (jQuery UI Touch Punch)

### **Responsive Design**
- Diseño adaptativo para todos los dispositivos
- Menús responsive
- Carrito optimizado para móviles

## 🔧 Instalación y Configuración

### **Requisitos**
- PHP 7.0 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)
- Extensiones PHP: mysqli, mail

### **Configuración**
1. Clonar el repositorio
2. Configurar base de datos en archivos de conexión
3. Importar estructura de base de datos
4. Configurar servidor de correo para envío de emails
5. Ajustar rutas en archivos de configuración

### **Notas de Desarrollo**
- **Likes funcionales**: Solo en hosting (problema de CORS en local)
- **URL local configurada**: Línea 1049 en productos.php
- **SweetAlert2**: Incluido vía include() para alertas tempranas

## 📊 Estado del Proyecto

### **✅ Completado**
- Frontend completo y funcional
- Sistema de usuarios y autenticación
- Carrito de compras operativo
- Panel de administración
- Proceso de compra (excepto pasarela real)
- Sistema de likes y mensajes

### **🔄 En Desarrollo**
- Panel de control para contenido del slider
- Edición dinámica de textos "Sobre Mí"
- Mejoras de CSS para dispositivos pequeños
- Integración de Stripe para pagos

### **🎯 Próximas Mejoras**
- Personalización completa de alertas SweetAlert2
- Optimización de responsive design
- Implementación de pasarela de pagos real
- Mejoras de seguridad en formularios

## 📝 Notas del Desarrollador

*"Considero que el proyecto está ya funcional. Lo que más me enorgullece es el sistema de ordenamiento visual de productos, que permite cambiar el orden de visualización simplemente arrastrando y soltando, manteniendo todas las funcionalidades intactas."*

**Fernando Chang**

---

## 📞 Contacto

Para consultas sobre el proyecto o colaboraciones, contactar a través del repositorio de GitHub.

**¡Gracias por revisar Los Cuadros de Rita!** 🎨✨
