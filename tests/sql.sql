INSERT INTO `materials`(`name`) VALUES
('szkło'),
('szkło bezpieczne'),
('szkło zespolone'),
('szkło zbrojone'),
('lustro'),
('lustro weneckie'),
('satyna'),
('lacobel'),
('lacomat'),
('ornament zwykły');


INSERT INTO `material_types`(`name`) VALUES
('opti'),
('kominkowe'),
('mirastar'),
('9003/1013'),
('mleczne'),
('bezbarwny'),
('srebro'),
('brąz/oranż'),
('brąz/grafit'),
('kolor inny');


INSERT INTO `service_lists`(`name`, `unit`, `price`) VALUES
('wycięcie pd','szt','7500'),
('wycięcie uszy misia','szt','7500'),
('wycięcia małe','szt','5000'),
('malowanie do 0,5m2','szt','11500'),
('roboczogodzina','szt','10000'),
('faza na kształtach','mb','5000'),
('faza extra łamana','mb','6000'),
('montaż kabin prysznicowych','m2','25000'),
('montaż ścian biurowych','m2','30000'),
('montaż luser/ekrany od 5 do 10m2','m2','13500'),
('montaż luster/ekrany od 2 do 5m2','m2','15000'),
('montaż luster/ekrany od 1 do 2m2','m2','17000'),
('montaż balustrad','m2','25000'),
('montaż luser/ekrany po 10m2','m2','10500'),
('hartowanie','m2','1220'),
('piaskowanie','m2','5000'),
('piaskowanie ozdobne','m2','25000'),
('malowanie','m2','23200'),
('szklenie ramy drewnianej','m2','6000'),
('szklenie szkłem zespolonym','m2','10500'),
('szklenie ram metalowych','m2','12600'),
('płynowanie','m2','5000'),
('zabezpieczenie piaskowania','m2','5000'),
('drukowanie na szkle','m2','33000'),
('laminowanie 4 warstwy foli','m2','31100'),
('aminowanie 3 warstwy foli','m2','27000'),
('foliowanie','m2','5000');


INSERT INTO `hole_prices`(`diameter_from`, `diameter_to`, `price`) VALUES
('1','10','500'),
('11','20','900'),
('21','30','1200'),
('31','40','1500'),
('41','59999','2000');


INSERT INTO `configs`
(
    `distance_km_price`,
    `free_delivery_from_price`,
    `free_delivery_distance`,
    `company_metadata`,
    `last_company_metadata`,
    `standard_order_time`,
    `time_of_order_limitation`,
    `printing_unit_glass_dimension`,
    `unit_glass_dimension`
)
VALUES
('200','1500000','15','Informacje o firmie','Poprzednie info o firmie','30','360','mm','cm');

INSERT INTO `place_of_deliveries`(`name`, `distance`) VALUES
('Adamowo','8'),
('Bielnik Drugi','10'),
('Bielnik Pierwszy','5'),
('Czechowo','11'),
('Dłużyna','16'),
('Elbląg','0'),
('Gajewiec','7'),
('Gronowo Elbląskie','13'),
('Gronowo Górne','6'),
('Helenowo','6'),
('Jagodnik','11'),
('Janów','11'),
('Jasionno','10'),
('Jegłownik','13'),
('Jezioro','10'),
('Jurandowo','9'),
('Kamiennik Wielki','16'),
('Karczowiska Górne','6'),
('Kazimierzowo','6'),
('Kępa Rybacka','11'),
('Kępiny Małe','17'),
('Kępiny Wielkie','13'),
('Kępki','11'),
('Komorowo Żuławskie','13'),
('Kopanka Pierwsza','15'),
('Leszno','0'),
('Milejewo','17'),
('Młynary','36'),
('Mojkowo','13'),
('Myślęcin','16'),
('Nogat','16'),
('Nowakowo','9'),
('Nowe Batorowo','12'),
('Nowina','9'),
('Nowy Dwór Elbląski','15'),
('Ogrodniki','17'),
('Oleśno','16'),
('Pasłęk','31'),
('Piastowo','12'),
('Pilona','14'),
('Przezmark-Osiedle','13'),
('Raczki Elbląskie','4'),
('Sierpin','13'),
('Suchacz','15'),
('Stobna','15'),
('Stoboje','12'),
('Szopy','9'),
('Tolkmicko','23'),
('Tropy Elbląskie','5'),
('Węgle-Żukowo','8'),
('Węzina','17'),
('Wiktorowo','11'),
('Żółwiniec','9'),
('Żurawiec','8'),
('Rychliki','23'),
('Jelonki','22'),
('Kadyny','18'),
('Pogrodzie','26'),
('Zielonka Pasłęcka','37'),
('Łęcze','15'),
('Markusy','12'),
('Kamionek Wielki','12');


--thickness in micro meter
INSERT INTO `glass_models`(`name`, `material_id`, `material_type_id`, `thickness`, `glass_mark`, `unit`, `price`) VALUES
('szkło 3mm','1',null,'3000',null,'m2','67'),
('szkło 4mm','1',null,'4000',null,'m2','84'),
('szkło 5mm','1',null,'5000',null,'m2','116'),
('szkło 6mm','1',null,'6000',null,'m2','139'),
('szkło 8mm','1',null,'8000',null,'m2','190'),
('szkło 10mm','1',null,'10000',null,'m2','236'),
('szkło 12mm','1',null,'12000',null,'m2','332'),
('szkło opti 4mm','1','1','4000',null,'m2','156'),
('szkło opti 5mm','1','1','5000',null,'m2','181'),
('szkło opti 6mm','1','1','6000',null,'m2','237'),
('szkło opti 8mm','1','1','8000',null,'m2','312'),
('szkło opti 10mm','1','1','10000',null,'m2','400'),
('szkło opti 12mm','1','1','12000',null,'m2','492'),
('szkło kominkowe','1','2','4000',null,'m2','1500'),
('szkło brąz/grafit 4mm','1','9','4000',null,'m2','119'),
('szkło brąz/grafit 6mm','1','9','6000',null,'m2','210'),
('szkło brąz/grafit 8mm','1','9','8000',null,'m2','295'),
('szkło brąz/grafit 10mm','1','9','10000',null,'m2','362'),
('lustro weneckie mirastar 4mm','6','3','4000',null,'m2','230'),
('lustro weneckie mirastar 6mm','6','3','6000',null,'m2','375'),
('lacobel 9003/1013','8','4','4000',null,'m2','275'),
('lacobel kolor inny','8','10','4000',null,'m2','227'),
('lacomat','9',null,'4000',null,'m2','251'),
('lustro brąz/grafit 4mm','5','9','4000',null,'m2','177'),
('lustro srebro 3mm','5','7','3000',null,'m2','110'),
('lustro srebro 4mm','5','7','4000',null,'m2','110'),
('lustro srebro 6mm','5','7','6000',null,'m2','155'),
('satyna 4mm','7',null,'4000',null,'m2','193'),
('satyna 6mm','7',null,'6000',null,'m2','239'),
('satyna 8mm','7',null,'8000',null,'m2','288'),
('satyna 10mm','7',null,'10000',null,'m2','350'),
('szkło bezpieczne 331','2',null,'6300','331','m2','160'),
('szkło bezpieczne 441','2',null,'8300','441','m2','193'),
('szkło bezpieczne 442','2',null,'8600','442','m2','271'),
('szkło bezpieczne mleczne 221','2','5','4300','221','m2','282'),
('szkło bezpieczne mleczne 331','2','5','6300','331','m2','232'),
('szkło bezpieczne mleczne 441','2','5','8300','441','m2','279'),
('ornament zwykły bezbarwny','10','6','4000',null,'m2','116'),
('ornament zwykły brąz/oranż','10','8','4000',null,'m2','160'),
('szkło zbrojone','4',null,'6000',null,'m2','136'),
('szkło zespolone 331/10/331','3',null,'24600','331/10/331','m2','410'),
('szkło zespolone 331/14/4','3',null,'24600','331/14/4','m2','320'),
('szkło zespolone 4/16/4','3',null,'24000','4/16/4','m2','190'),
('szkło zespolone 442/14/4','3',null,'26600','442/14/4','m2','420'),
('szkło zespolone 444/12/331','3',null,'27000','444/12/331','m2','600'),
('szkło zespolone 444/12/4','3',null,'24000','444/12/4','m2','490'),
('szkło zespolone 5/14/5','3',null,'24000','5/14/5','m2','210'),
('szkło zespolone kolor/14/4','3',null,'22000','kolor/14/4','m2','210'),
('szkło zespolone mirastar/16/4','3',null,'24000','mirastar/16/4','m2','350');


INSERT INTO `cut_models`(`name`, `material_id`, `material_type_id`, `thickness_from`, `thickness_to`, `unit`, `price`) VALUES
('sztorc/poler',null,null,null,null,'m2','160'),
('sztorc/mat',null,null,null,null,'m2','135'),
('zatępianie',null,null,null,null,'mb','060'),
('podwójna zejma',null,null,null,null,'szt','320'),
('fazowanie do  20mm grubość szkła 4mm',null,null,'0','20','mb','2200'),
('fazowanie pow 20mm grubość szkła 4mm',null,null,'20',null,'mb','2700'),
('fazowanie do  20mm grubość szkła 6mm',null,null,'0','20','mb','3000'),
('fazowanie pow 20mm grubość szkła 6mm',null,null,'20',null,'mb','3500'),
('fazowanie do  20mm grubość szkła 8mm',null,null,'0','20','mb','3200'),
('fazowanie pow 20mm grubość szkła 8mm',null,null,'20',null,'mb','3700');


INSERT INTO `users`(`name`, `email`, `password`, `created_at`, `updated_at`) VALUES
('root','root@root','$2y$10$cSQdfdz/9pDAe8MSmsuPYemtbW7U.v4QwJdtETe7KP6HfCBtczMDW','2019-04-19 17:06:55','2019-04-24 18:06:55'),
('mis','mis@mis','$2y$10$hxiKbChn/hNzr0.ExwQfreB9dJ8rZ8.a3dsklObRF2esSQ0epoVgO','2019-04-24 18:06:55','2019-04-24 18:06:55');

-- root@root, root, archaniol
-- mis@mis, mis , mis&2019

---------------------------------------EXAMPLE DATA------------------------------------------

INSERT INTO `clients`(`full_name`, `phone_number`, `place_of_delivery_id`, `default_distance`) VALUES
('Piotr Rogalski','506 901 791','6','0'),
('Stanisław Wyszyński','123 456 789','2','0'),
('Ola Bek','123 456 789','2','0'),
('Ola','123 456 789','2','0'),
('ImięPietnastoLi NazwiskoTrzydziestoLiteroweŁał','987 654 321','4','0');

INSERT INTO `orders`
(
    `order_system_number`,
    `client_id`,
    `advance`,
    `distance`,
    `percentage_discount`,
    `total_penny_order_sum`,
    `created_at`,
    `deadline_at`
)
VALUES
('Nr001/04/2019','1','0','0','0','10000','2019-03-19 09:35:21','2019-04-19 09:35:21'),
('Nr002/04/2019','1','100','0','0','10000','2019-03-20 09:35:21','2019-04-20 09:35:21'),
('Nr003/04/2019','2','0','12','0','10000','2019-03-20 09:35:21','2019-05-20 09:35:21'),
('Nr004/04/2019','3','0','30','0','10000','2019-03-20 09:35:21','2019-05-20 09:35:21'),
('Nr005/04/2019','4','0','15','0','10000','2019-02-20 09:35:21','2019-03-20 09:35:21'),
('Nr006/04/2019','5','0','0','10','10000','2019-03-20 09:35:21','2019-04-20 09:35:21');






