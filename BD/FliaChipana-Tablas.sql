create database fliachipana

use fliachipana

--Creacion de tablas------------------------------------------
create table usuarios(
id_usuario int primary key,
nombre nvarchar(60),
contraseña nvarchar(60),
rol nvarchar(60))
go


create table clientes(
id_cliente int primary key,
nombre nvarchar(60),
apellido nvarchar(60),
telefono nvarchar(15),
direccion nvarchar(60),
email nvarchar(60),
deuda decimal(18,2))
go


create table proveedores(
id_proveedor int primary key,
nombre nvarchar(60),
telefono nvarchar(15),
email nvarchar(60),
direccion nvarchar(60))
go

create table productos(
id_producto bigint primary key,
descripcion nvarchar(60),
stock decimal(18,2),
id_proveedor int,
foreign key (id_proveedor) references proveedores(id_proveedor),
precio decimal(18,2),
costo decimal(18,2),
fecha_cad date)
go


create table forma_pago(
id_forma_pago int primary key,
descripcion nvarchar(60))
go


create table ventas(
id_venta bigint primary key,
id_usuario int,
foreign key (id_usuario) references usuarios(id_usuario),
fecha datetime,
id_cliente int,
foreign key (id_cliente) references clientes(id_cliente),
total decimal(18,2),
descuento decimal(18,2))
go


create table detalle_venta(
id_venta bigint,
foreign key (id_venta) references ventas(id_venta),
id_producto bigint,
foreign key (id_producto) references productos(id_producto),
precio_total decimal(18,2),
cantidad decimal(18,2),
precio decimal(18,2))
go


create table detalle_forma_pago(
id_venta bigint,
foreign key (id_venta) references ventas(id_venta),
id_forma_pago int,
foreign key (id_forma_pago) references forma_pago(id_forma_pago),
importe decimal(18,2))
go
---------------------------------------------------------------

--Alta---------------------------------------------------------
----Productos--------------------------------------------------
create procedure spu_crear_producto
@id_producto bigint,
@descripcion nvarchar(60),
@stock decimal(18,2),
@id_proveedor int,
@precio decimal(18,2),
@costo decimal(18,2),
@fecha date
as
insert into productos	
values(@id_producto,@descripcion,@stock,@id_proveedor,@precio,@costo,@fecha)

exec spu_crear_producto 1,'Producto Prueba',10,1,1500,3000,'15/12/2026'
----------------------------------------------------------------

----Cliente-----------------------------------------------------
create procedure spu_crear_cliente
@id_cliente int,
@nombre nvarchar(60),
@apellido nvarchar(60),
@telefono nvarchar(15),
@direccion nvarchar(60),
@email nvarchar(60),
@deuda decimal(18,2)
as
insert into clientes
values(@id_cliente,@nombre,@apellido,@telefono,@direccion,@email,@deuda)

exec spu_crear_cliente 1,'Gonzalo','Valor','341111111111','Ayacucho','gmvalor@gmail.com',82500
-----------------------------------------------------------------

----Usuarios-----------------------------------------------------
create procedure spu_crear_usuarios
@id_usuario int,
@nombre nvarchar(60),
@contraseña nvarchar(60),
@rol nvarchar(60)
as
insert into usuarios
values(@id_usuario,@nombre,@contraseña,@rol)

exec spu_crear_usuarios 1,'Lautaro','mani123','Admin'
-----------------------------------------------------------------

----Proveedores--------------------------------------------------
create procedure spu_crear_proveedores
@id_proveedor int,
@nombre nvarchar(60),
@telefono nvarchar(15),
@email nvarchar(60),
@direccion nvarchar(60)
as
insert into proveedores
values(@id_proveedor,@nombre,@telefono,@email,@direccion)

exec spu_crear_proveedores 1,'Yasmin inc','34111111111','yasminarvalo@gmail.com','Carriego 1778'
-----------------------------------------------------------------

----Forma de Pago------------------------------------------------
create procedure spu_crear_forma_pago
@id_forma_pago int,
@descripcion nvarchar(60)
as
insert into forma_pago
values(@id_forma_pago,@descripcion)

exec spu_crear_forma_pago 1,'Efectivo'
-----------------------------------------------------------------

------Detalle de Forma de Pago-----------------------------------
create procedure spu_crear_detalle_forma_pago
@id_venta bigint,
@id_forma_pago int,
@importe decimal(18,2)
as
insert into detalle_forma_pago
values(@id_venta,@id_forma_pago,@importe)

exec spu_crear_detalle_forma_pago 1,1,85500
-----------------------------------------------------------------

----Venta--------------------------------------------------------
create procedure spu_crear_ventas
@id_venta bigint,
@id_usuario int,
@fecha datetime,
@id_cliente int,
@total decimal(18,2),
@descuento decimal(18,2)
as
insert into ventas
values(@id_venta,@id_usuario,@fecha,@id_cliente,@total,@descuento)

exec spu_crear_venta 1,1,'15/10/2024',1,85500,0
-----------------------------------------------------------------

------Detalle de Venta-------------------------------------------
create procedure spu_crear_detalle_ventas
@id_venta bigint,
@id_producto bigint,
@precio_total decimal(18,2),
@cantidad decimal(18,2),
@precio decimal(18,2)
as
insert into detalle_venta
values(@id_venta,@id_producto,@precio_total,@cantidad,@precio)

exec spu_crear_detalle_ventas 1,1,6000,2,3000
-----------------------------------------------------------------

--Baja-----------------------------------------------------------
----Productos----------------------------------------------------
create procedure spu_eliminar_producto
@id_producto bigint
as
delete from productos
where id_producto = @id_producto

exec spu_eliminar_producto 1
-----------------------------------------------------------------

----Cliente------------------------------------------------------

-----------------------------------------------------------------