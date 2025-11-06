use fliachipana
--Creación de triggers para controlar el stock de los productos-----------
----Trigger para bajar el stock-------------------------------------------
create trigger tgr_bajar_stock on detalle_venta
after insert
as
begin
	update productos set stock = stock - inserted.cantidad from productos
	inner join inserted on productos.id_producto = inserted.id_producto
	where stock >= inserted.cantidad
end
--------------------------------------------------------------------------

----Trigger para subir el stock-------------------------------------------
create trigger tgr_subir_stock on detalle_venta
after delete
as
begin
	update productos set stock = stock + deleted.cantidad from productos
	inner join deleted on productos.id_producto = deleted.id_producto
end
--------------------------------------------------------------------------

