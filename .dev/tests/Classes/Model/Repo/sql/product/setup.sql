DELETE FROM xlite_categories;
DELETE FROM xlite_category_images;
DELETE FROM xlite_category_translations;
DELETE FROM xlite_category_products;
DELETE FROM xlite_category_quick_flags;
DELETE FROM xlite_products;
DELETE FROM xlite_product_translations;
DELETE FROM xlite_product_images;

INSERT INTO xlite_categories VALUES (1,0,1,6,0,1,'',1);
INSERT INTO xlite_categories VALUES (14015,1,2,3,0,1,'fruit',1);
INSERT INTO xlite_categories VALUES (14009,1,4,5,0,1,'vegetables',1);

INSERT INTO xlite_category_quick_flags VALUES (1,1,2,2);
INSERT INTO xlite_category_quick_flags VALUES (2,14015,0,0);
INSERT INTO xlite_category_quick_flags VALUES (3,14009,0,0);

INSERT INTO xlite_category_translations VALUES (1,'en',0,'','','','','');
INSERT INTO xlite_category_translations VALUES (2,'en',14015,'Fruit','<p>In botany, a fruit is the ripened ovary, together with its seeds, of a flowering plant. In cuisine, when discussing fruit as food, the term usually refers to just those plant fruits that are sweet and fleshy, examples of which would be plum, apple, and orange. However, a great many common vegetables, as well as nuts and grains, are the fruit of the plants they come from. Fruits that might not be considered such in a culinary context include gourds (e.g. squash and pumpkin), maize, tomatoes, and green peppers. These are fruits to a botanist, but are generally treated as vegetables in cooking. Some spices, such as allspice and nutmeg, are fruits. Rarely, culinary \"fruits\" are not fruits in the botanical sense, such as rhubarb in which only the sweet leaf petiole is edible.</p>\n<p>The term false fruit is sometimes applied to a fruit, like the fig (a multiple-accessory fruit) or to a plant structure that resembles a fruit but is not derived from a flower or flowers. Some gymnosperms, such as yew, have fleshy arils that resemble fruits and some junipers have berry-like, fleshy cones.</p>\n<div style=\"padding: 24px 24px 24px 21px; display: block; background-color: #ececec;\">From <a style=\"color: #1e7ec8; text-decoration: underline;\" title=\"\" href=\"http://www.knowledgerush.com\">www.knowledgerush.com</a></div>','','','');
INSERT INTO xlite_category_translations VALUES (3,'en',14009,'Vegetables','<p>Vegetable is a nutritional and culinary term denoting any part of a plant that is commonly consumed by humans as food, but is not regarded as a culinary fruit, nut, herb, spice, or grain. In common usage, vegetables include the leaves (e.g. lettuce), stems (asparagus), and roots (carrot) of various plants. But the term can also encompass non-sweet fruits such as seed-pods (beans), cucumbers, squashes, pumpkins, tomatoes, avocadoes, green peppers, etc.; even some seeds (peas and beans) that are easily softened by soaking.</p>\n<div style=\"padding: 24px 24px 24px 21px; display: block; background-color: #ececec;\">From <a style=\"color: #1e7ec8; text-decoration: underline;\" title=\"\" href=\"http://www.knowledgerush.com\">www.knowledgerush.com</a></div>','','','');

INSERT INTO `xlite_products` (`product_id`, `price`, `sale_price`, `sku`, `enabled`, `weight`, `tax_class`, `free_shipping`, `clean_url`) VALUES (15090,'1.99','1.99','00000',1,'0.32','',0,'');
INSERT INTO `xlite_products` (`product_id`, `price`, `sale_price`, `sku`, `enabled`, `weight`, `tax_class`, `free_shipping`, `clean_url`) VALUES (16281,'1.15','1.15','00007',1,'0.31','',0,'');
INSERT INTO `xlite_products` (`product_id`, `price`, `sale_price`, `sku`, `enabled`, `weight`, `tax_class`, `free_shipping`, `clean_url`) VALUES (16280,'3.45','3.45','00006',1,'0.55','',0,'');
INSERT INTO `xlite_products` (`product_id`, `price`, `sale_price`, `sku`, `enabled`, `weight`, `tax_class`, `free_shipping`, `clean_url`) VALUES (16282,'1.12','1.12','00008',1,'0.35','',0,'test');
INSERT INTO `xlite_products` (`product_id`, `price`, `sale_price`, `sku`, `enabled`, `weight`, `tax_class`, `free_shipping`, `clean_url`) VALUES (15121,'5.99','5.99','00004',1,'0.32','',0,'');
INSERT INTO `xlite_products` (`product_id`, `price`, `sale_price`, `sku`, `enabled`, `weight`, `tax_class`, `free_shipping`, `clean_url`) VALUES (15123,'1.99','1.99','00005',1,'0.32','',0,'');
INSERT INTO `xlite_products` (`product_id`, `price`, `sale_price`, `sku`, `enabled`, `weight`, `tax_class`, `free_shipping`, `clean_url`) VALUES (15068,'2.99','2.99','00003',0,'0.32','',0,'disabled');
INSERT INTO `xlite_products` (`product_id`, `price`, `sale_price`, `sku`, `enabled`, `weight`, `tax_class`, `free_shipping`, `clean_url`) VALUES (15091,'8.99','8.99','00002',1,'0.32','',0,'');
INSERT INTO `xlite_products` (`product_id`, `price`, `sale_price`, `sku`, `enabled`, `weight`, `tax_class`, `free_shipping`, `clean_url`) VALUES (15067,'2.49','2.49','00001',1,'0.32','',0,'');

INSERT INTO `xlite_product_translations` (`label_id`, `code`, `id`, `name`, `description`, `brief_description`, `meta_tags`, `meta_desc`, `meta_title`) VALUES (1,'en',15090,'Apple','<h5>Apple</h5>\n<p>The apple is the pomaceous fruit of the apple tree, species Malus domestica in the rose family Rosaceae. It is one of the most widely cultivated tree fruits. The tree is small and deciduous, reaching 3 to 12 metres (9.8 to 39 ft) tall, with a broad, often densely twiggy crown. The leaves are alternately arranged simple ovals 5 to 12 cm long and 3&ndash;6 centimetres (1.2&ndash;2.4 in) broad on a 2 to 5 centimetres (0.79 to 2.0 in) petiole with an acute tip, serrated margin and a slightly downy underside. Blossoms are produced in spring simultaneously with the budding of the leaves. The flowers are white with a pink tinge that gradually fades, five petaled, and 2.5 to 3.5 centimetres (0.98 to 1.4 in) in diameter. The fruit matures in autumn, and is typically 5 to 9 centimetres (2.0 to 3.5 in) diameter. The center of the fruit contains five carpels arranged in a five-point star, each carpel containing one to three seeds.</p>\n<p>The tree originated from Central Asia, where its wild ancestor is still found today. There are more than 7,500 known cultivars of apples resulting in a range of desired characteristics. Cultivars vary in their yield and the ultimate size of the tree, even when grown on the same rootstock.</p>\n<p>vAt least 55 million tonnes of apples were grown worldwide in 2005, with a value of about $10 billion. China produced about 35% of this total. The United States is the second leading producer, with more than 7.5% of the world production. Turkey, France, Italy, and Iran are also among the leading apple exporters.</p>\n<p>&nbsp;</p>\n<div style=\"padding: 24px 24px 24px 21px; display: block; background-color: #ececec;\">From <a style=\"color: #1e7ec8; text-decoration: underline;\" title=\"Wikipedia\" href=\"http://en.wikipedia.org\">Wikipedia</a>, the free encyclopedia</div>','','','','');
INSERT INTO `xlite_product_translations` (`label_id`, `code`, `id`, `name`, `description`, `brief_description`, `meta_tags`, `meta_desc`, `meta_title`) VALUES (2,'en',16281,'Radish','<h5>Radish</h5>\n<p>The radish (Raphanus sativus) is an edible root vegetable of the Brassicaceae family that was domesticated in Europe in pre-Roman times. They are grown and consumed throughout the world. Radishes have numerous varieties, varying in size, color and duration of required cultivation time. There are some radishes that are grown for their seeds; oilseed radishes are grown, as the name implies, for oil production.</p>\n<p>&nbsp;</p>\n<div style=\"padding: 24px 24px 24px 21px; display: block; background-color: #ececec;\">From <a style=\"color: #1e7ec8; text-decoration: underline;\" title=\"Wikipedia\" href=\"http://en.wikipedia.org\">Wikipedia</a>, the free encyclopedia</div>','','','','');
INSERT INTO `xlite_product_translations` (`label_id`, `code`, `id`, `name`, `description`, `brief_description`, `meta_tags`, `meta_desc`, `meta_title`) VALUES (3,'en',16280,'Pea','<h5>Pea</h5>\n<p>A pea is most commonly the small spherical seed or the seed-pod of the legume Pisum sativum. Each pod contains several peas. Although it is botanically a fruit, it is treated as a vegetable in cooking. The name is also used to describe other edible seeds from the Fabaceae such as the pigeon pea (Cajanus cajan), the cowpea (Vigna unguiculata), and the seeds from several species of Lathyrus.</p>\n<p>P. sativum is an annual plant, with a life cycle of one year. It is a cool season crop grown in many parts of the world; planting can take place from winter through to early summer depending on location. The average pea weighs between 0.1 and 0.36 grams. The species is used as a vegetable - fresh, frozen or canned, and is also grown to produce dry peas like the split pea. These varieties are typically called field peas.</p>\n<p>The wild pea is restricted to the Mediterranean basin and the Near East. The earliest archaeological finds of peas come from Neolithic Syria, Turkey and Jordan. In Egypt, early finds come from c. 4800&ndash;4400 BC in the delta area, and from c. 3800&ndash;3600 BC in Upper Egypt. The pea was also present in 5th millennium BC Georgia. Further east, the finds are younger. Pea remains were retrieved from Afghanistan c. 2000 BC. They were present in 2250&ndash;1750 BC Harappa Pakistan and north-west India, from the older phases of this culture onward. In the second half of the 2nd millennium BC this pulse crop appears in the Gangetic basin and southern India.</p>\n<p>&nbsp;</p>\n<div style=\"padding: 24px 24px 24px 21px; display: block; background-color: #ececec;\">From <a style=\"color: #1e7ec8; text-decoration: underline;\" title=\"Wikipedia\" href=\"http://en.wikipedia.org\">Wikipedia</a>, the free encyclopedia</div>','','','','');
INSERT INTO `xlite_product_translations` (`label_id`, `code`, `id`, `name`, `description`, `brief_description`, `meta_tags`, `meta_desc`, `meta_title`) VALUES (4,'en',16282,'Cucumber','<h5>Cucumber</h5>\n<p>The cucumber (Cucumis sativus) is a widely cultivated plant in the gourd family Cucurbitaceae, which includes squash, and in the same genus as the muskmelon.</p>\n<p>&nbsp;</p>\n<div style=\"padding: 24px 24px 24px 21px; display: block; background-color: #ececec;\">From <a style=\"color: #1e7ec8; text-decoration: underline;\" title=\"Wikipedia\" href=\"http://en.wikipedia.org\">Wikipedia</a>, the free encyclopedia</div>','','','','');
INSERT INTO `xlite_product_translations` (`label_id`, `code`, `id`, `name`, `description`, `brief_description`, `meta_tags`, `meta_desc`, `meta_title`) VALUES (5,'en',15121,'Cherry','<h5>Cherry</h5>\n<p>The word cherry refers to a fleshy fruit (drupe) that contains a single stony seed. The cherry belongs to the family Rosaceae, genus Prunus, along with almonds, peaches, plums, apricots and bird cherries. The subgenus, Cerasus, is distinguished by having the flowers in small corymbs of several together (not singly, nor in racemes), and by having a smooth fruit with only a weak groove or none along one side. The subgenus is native to the temperate regions of the Northern Hemisphere, with two species in America, three in Europe, and the remainder in Asia.</p>\n<p>&nbsp;</p>\n<div style=\"padding: 24px 24px 24px 21px; display: block; background-color: #ececec;\">From <a style=\"color: #1e7ec8; text-decoration: underline;\" title=\"Wikipedia\" href=\"http://en.wikipedia.org\">Wikipedia</a>, the free encyclopedia</div>','','','','');
INSERT INTO `xlite_product_translations` (`label_id`, `code`, `id`, `name`, `description`, `brief_description`, `meta_tags`, `meta_desc`, `meta_title`) VALUES (6,'en',15123,'Strawberry','<h5>Garden strawberry</h5>\n<p>Garden strawberries are a common variety of strawberry cultivated worldwide. Like other species of Fragaria (strawberries), it belongs to the family Rosaceae. Technically, it is not a fruit but a false fruit, meaning the fleshy part is derived not from the plant\'s ovaries (achenes) but from the peg at the bottom of the bowl-shaped hypanthium that holds the ovaries.</p>\n<p>The Garden Strawberry was first bred in Brittany, France in 1740 via a cross of Fragaria virginiana from eastern North America , which was noted for its flavor, and Fragaria chiloensis from Chile brought by Am&eacute;d&eacute;e-Fran&ccedil;ois_Fr&eacute;zier, which was noted for its large size.</p>\n<p>Cultivars of Fragaria &times; ananassa have replaced, in commercial production, the Woodland Strawberry, which was the first strawberry species cultivated in the early 17th century.</p>\n<p>&nbsp;</p>\n<div style=\"padding: 24px 24px 24px 21px; display: block; background-color: #ececec;\">From <a style=\"color: #1e7ec8; text-decoration: underline;\" title=\"Wikipedia\" href=\"http://en.wikipedia.org\">Wikipedia</a>, the free encyclopedia</div>','','','','');
INSERT INTO `xlite_product_translations` (`label_id`, `code`, `id`, `name`, `description`, `brief_description`, `meta_tags`, `meta_desc`, `meta_title`) VALUES (7,'en',15068,'Orange','<h5>Orange</h5>\n<p>An orange&mdash;specifically, the sweet orange&mdash;is the citrus Citrus &times;sinensis (syn. Citrus aurantium L. var. dulcis L., or Citrus aurantium Risso) and its fruit. The orange is a hybrid of ancient cultivated origin, possibly between pomelo (Citrus maxima) and tangerine (Citrus reticulata). It is a small flowering tree growing to about 10 m tall with evergreen leaves, which are arranged alternately, of ovate shape with crenulate margins and 4&ndash;10 cm long. The orange fruit is a hesperidium, a type of berry.</p>\n<p>Oranges originated in Southeast Asia. The fruit of Citrus sinensis is called sweet orange to distinguish it from Citrus aurantium, the bitter orange. The name is thought to ultimately derive from the Dravidian and Telugu word for the orange tree, with its final form developing after passing through numerous intermediate languages.</p>\n<p>In a number of languages, it is known as a \"Chinese apple\" (e.g. Dutch Sinaasappel, \"China\'s apple\", or \"Apfelsine\" in German).</p>\n<p>&nbsp;</p>\n<div style=\"padding: 24px 24px 24px 21px; display: block; background-color: #ececec;\">From <a style=\"color: #1e7ec8; text-decoration: underline;\" title=\"Wikipedia\" href=\"http://en.wikipedia.org\">Wikipedia</a>, the free encyclopedia</div>','','','','');
INSERT INTO `xlite_product_translations` (`label_id`, `code`, `id`, `name`, `description`, `brief_description`, `meta_tags`, `meta_desc`, `meta_title`) VALUES (8,'en',15091,'Peach','<h5>Peach</h5>\n<p>The peach (Prunus persica) is known as a species of Prunus native to China that bears an edible juicy fruit also called a peach. It is a deciduous tree growing to 5&ndash;10 m tall, belonging to the subfamily Prunoideae of the family Rosaceae. It is classified with the almond in the subgenus Amygdalus within the genus Prunus, distinguished from the other subgenera by the corrugated seed shell.</p>\n<p>The leaves are lanceolate, 7&ndash;15 cm long (3&ndash;6 in), 2&ndash;3 cm broad, pinnately veined. The flowers are produced in early spring before the leaves; they are solitary or paired, 2.5&ndash;3 cm diameter, pink, with five petals. The fruit has yellow or whitish flesh, a delicate aroma, and a skin that is either velvety (peaches) or smooth (nectarines) in different cultivars. The flesh is very delicate and easily bruised in some cultivars, but is fairly firm in some commercial varieties, especially when green. The single, large seed is red-brown, oval shaped, approximately 1.3&ndash;2 cm long, and is surrounded by a wood-like husk. Peaches, along with cherries, plums and apricots, are stone fruits (drupes). The tree is small, and up to 15 ft tall.</p>\n<p>The scientific name persica, along with the word \"peach\" itself and its cognates in many European languages, derives from an early European belief that peaches were native to Persia (now Iran). The modern botanical consensus is that they originate in China, and were introduced to Persia and the Mediterranean region along the Silk Road before Christian times.[1] Cultivated peaches are divided into clingstones and freestones, depending on whether the flesh sticks to the stone or not; both can have either white or yellow flesh. Peaches with white flesh typically are very sweet with little acidity, while yellow-fleshed peaches typically have an acidic tang coupled with sweetness, though this also varies greatly. Both colours often have some red on their skin. Low-acid white-fleshed peaches are the most popular kinds in China, Japan, and neighbouring Asian countries, while Europeans and North Americans have historically favoured the acidic, yellow-fleshed kinds.</p>\n<p>&nbsp;</p>\n<div style=\"padding: 24px 24px 24px 21px; display: block; background-color: #ececec;\">From <a style=\"color: #1e7ec8; text-decoration: underline;\" title=\"Wikipedia\" href=\"http://en.wikipedia.org\">Wikipedia</a>, the free encyclopedia</div>','','','','');
INSERT INTO `xlite_product_translations` (`label_id`, `code`, `id`, `name`, `description`, `brief_description`, `meta_tags`, `meta_desc`, `meta_title`) VALUES (9,'en',15067,'Pear','<h5>Pear</h5>\n<p>The pear is an edible pomaceous fruit produced by a tree of genus Pyrus (pronounced /�~K�~Fpa�~Iªr�~I�~D�s/). The pear is classified within Maloideae, a subfamily within Rosaceae. The apple (Malus &times;domestica), which it resembles in floral structure, is also a member of this subfamily.</p>\n<p>The English word pear is probably from Common West Germanic *pera, probably a loanword of Vulgar Latin pira, the plural of pirum, akin to Greek api(r)os, which is likely of Semitic origin. The place name Perry can indicate the historical presence of pear trees. The term \"pyriform\" is sometimes used to describe something which is \"pear-shaped\".!</p>\n<p>&nbsp;</p>\n<div style=\"padding: 24px 24px 24px 21px; display: block; background-color: #ececec;\">From <a style=\"color: #1e7ec8; text-decoration: underline;\" title=\"Wikipedia\" href=\"http://en.wikipedia.org\">Wikipedia</a>, the free encyclopedia</div>','','','','');

INSERT INTO `xlite_product_images` (`image_id`, `id`, `path`, `mime`, `width`, `height`, `size`, `date`, `hash`) VALUES (1,15090,'demo_p15090.jpeg','image/jpeg',500,476,125664,1280314462,'');
INSERT INTO `xlite_product_images` (`image_id`, `id`, `path`, `mime`, `width`, `height`, `size`, `date`, `hash`) VALUES (2,16281,'demo_p16281.jpeg','image/jpeg',480,449,147088,1280314462,'');
INSERT INTO `xlite_product_images` (`image_id`, `id`, `path`, `mime`, `width`, `height`, `size`, `date`, `hash`) VALUES (3,16280,'demo_p16280.jpeg','image/jpeg',480,320,89674,1280314462,'');
INSERT INTO `xlite_product_images` (`image_id`, `id`, `path`, `mime`, `width`, `height`, `size`, `date`, `hash`) VALUES (4,16282,'demo_p16282.jpeg','image/jpeg',480,381,152246,1280314462,'');
INSERT INTO `xlite_product_images` (`image_id`, `id`, `path`, `mime`, `width`, `height`, `size`, `date`, `hash`) VALUES (5,15121,'demo_p15121.jpeg','image/jpeg',480,461,148125,1280314462,'');
INSERT INTO `xlite_product_images` (`image_id`, `id`, `path`, `mime`, `width`, `height`, `size`, `date`, `hash`) VALUES (6,15123,'demo_p15123.jpeg','image/jpeg',480,338,136546,1280314462,'');
INSERT INTO `xlite_product_images` (`image_id`, `id`, `path`, `mime`, `width`, `height`, `size`, `date`, `hash`) VALUES (7,15068,'demo_p15068.jpeg','image/jpeg',480,480,131972,1280314462,'');
INSERT INTO `xlite_product_images` (`image_id`, `id`, `path`, `mime`, `width`, `height`, `size`, `date`, `hash`) VALUES (8,15091,'demo_p15091.jpeg','image/jpeg',480,480,163746,1280314462,'');
INSERT INTO `xlite_product_images` (`image_id`, `id`, `path`, `mime`, `width`, `height`, `size`, `date`, `hash`) VALUES (9,15067,'demo_p15067.jpeg','image/jpeg',319,480,99541,1280314462,'');

INSERT INTO `xlite_category_products` SET product_id = '15090', category_id = '14015', orderby = '0';
INSERT INTO `xlite_category_products` SET product_id = '16281', category_id = '14009', orderby = '0';
INSERT INTO `xlite_category_products` SET product_id = '16280', category_id = '14009', orderby = '0';
INSERT INTO `xlite_category_products` SET product_id = '16282', category_id = '14009', orderby = '0';
INSERT INTO `xlite_category_products` SET product_id = '15121', category_id = '14015', orderby = '0';
INSERT INTO `xlite_category_products` SET product_id = '15123', category_id = '14015', orderby = '0';
INSERT INTO `xlite_category_products` SET product_id = '15068', category_id = '14015', orderby = '0';
INSERT INTO `xlite_category_products` SET product_id = '15091', category_id = '14015', orderby = '0';
INSERT INTO `xlite_category_products` SET product_id = '15067', category_id = '14015', orderby = '0';

