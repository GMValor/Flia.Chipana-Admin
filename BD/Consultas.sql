use fliachipana

--Listado de todos los productos con su proveedor----
create view vw_listado_productos_proveedor
as
select id_producto, descripcion, precio as 'Precio de venta', costo as 'Precio de compra', fecha_cad, productos.id_proveedor, proveedores.nombre  from productos
inner join proveedores on productos.id_proveedor = proveedores.id_proveedor
-----------------------------------------------------

--Productos m�s vendidos durante un periodo de tiempo--
create procedure spu_producto_mas_vendido_por_fecha
@fecha_desde date,
@fecha_hasta date
as
select detalle_venta.id_producto, productos.descripcion, SUM(cantidad) as 'Cantidad vendida', SUM(precio_total) as 'Ingresos totales' from detalle_venta
inner join productos on detalle_venta.id_producto = productos.id_producto
inner join ventas on detalle_venta.id_venta = ventas.id_venta
where ventas.fecha between @fecha_desde and @fecha_hasta
group by detalle_venta.id_producto,productos.descripcion 
order by sum(cantidad) desc
--------------------------------------------------------

--Filtrado de venta por fecha---------------------------
create procedure spu_filtrar_venta_por_fecha
@fecha_desde date,
@fecha_hasta date
as
select id_venta,ventas.id_usuario,usuarios.nombre,ventas.id_cliente,clientes.nombre,total,descuento,fecha from ventas
inner join usuarios on ventas.id_usuario = usuarios.id_usuario
inner join clientes on ventas.id_cliente = clientes.id_cliente
where fecha between @fecha_desde and @fecha_hasta
--------------------------------------------------------


--Filtrado de producto por proveedor--------------------
create procedure spu_filtrar_producto_por_proveedor
@id_proveedor int
as
select id_producto,descripcion,stock,productos.id_proveedor,proveedores.nombre,precio,costo,fecha_cad from productos
inner join proveedores on productos.id_proveedor = proveedores.id_proveedor
where productos.id_proveedor = @id_proveedor
--------------------------------------------------------


--Filtrar productos por fecha de caducidad--------------
create procedure spu_filtrar_producto_por_fecha_caducidad
@fecha_desde date,
@fecha_hasta date
as
select id_producto,descripcion,stock,precio,costo,fecha_cad from productos
where fecha_cad between @fecha_desde and @fecha_hasta
--------------------------------------------------------