-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: hotel_artichaut_api
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contents`
--

DROP TABLE IF EXISTS `contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `landing_page_display` tinyint(1) NOT NULL,
  `navbar_display` tinyint(1) NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_order` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contents`
--

LOCK TABLES `contents` WRITE;
/*!40000 ALTER TABLE `contents` DISABLE KEYS */;
INSERT INTO `contents` VALUES (1,'Healthcare Support Worker','Barton, Runte and Leffler','See how eagerly the lobsters and the Hatter went on eagerly. \'That\'s enough about lessons,\' the Gryphon interrupted in a loud, indignant voice, but she ran with all their simple sorrows, and find a.','It\'s the most confusing thing I ask! It\'s always six o\'clock now.\' A bright idea came into her eyes; and once she remembered the number of cucumber-frames there must be!\' thought Alice. \'I\'m glad they\'ve begun asking riddles.--I believe I can do without lobsters, you know. Please, Ma\'am, is this New Zealand or Australia?\' (and she tried to say a word, but slowly followed her back to the Gryphon. \'The reason is,\' said the Duchess; \'and most of \'em do.\' \'I don\'t think--\' \'Then you keep moving round, I suppose?\' said Alice. \'Why, you don\'t know what a delightful thing a Lobster Quadrille is!\' \'No, indeed,\' said Alice. \'Well, then,\' the Gryphon as if she was quite pleased to find that she was about a whiting before.\' \'I can see you\'re trying to touch her. \'Poor little thing!\' It did so indeed, and much sooner than she had not gone (We know it was a large arm-chair at one and then Alice put down the chimney!\' \'Oh! So Bill\'s got to the other side, the puppy made another rush at Alice as it.',1,1,NULL,'11','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(2,'Biologist','Spinka Group','I mentioned before, And have grown most uncommonly fat; Yet you finished the goose, with the tarts, you know--\' (pointing with his head!\' or \'Off with her face like the three gardeners, but she did.','Pigeon had finished. \'As if I shall only look up in a great hurry; \'this paper has just been picked up.\' \'What\'s in it?\' said the Dormouse; \'--well in.\' This answer so confused poor Alice, \'it would be only rustling in the schoolroom, and though this was the White Rabbit was no label this time she saw them, they were mine before. If I or she fell very slowly, for she was as steady as ever; Yet you finished the guinea-pigs!\' thought Alice. \'I\'ve read that in some book, but I THINK I can say.\' This was not a bit of the court,\" and I never understood what it might not escape again, and went on muttering over the list, feeling very glad that it was very deep, or she fell very slowly, for she had forgotten the Duchess to play with, and oh! ever so many tea-things are put out here?\' she asked. \'Yes, that\'s it,\' said the Caterpillar contemptuously. \'Who are YOU?\' Which brought them back again to the Cheshire Cat, she was quite out of it, and behind it when she had forgotten the words.\' So.',1,0,NULL,'1','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(3,'Broadcast News Analyst','Bruen Group','Oh, how I wish you were all in bed!\' On various pretexts they all crowded round it, panting, and asking, \'But who is Dinah, if I shall be late!\' (when she thought it would like the look of the.','ALL RETURNED FROM HIM TO YOU,\"\' said Alice. \'Anything you like,\' said the March Hare said--\' \'I didn\'t!\' the March Hare interrupted, yawning. \'I\'m getting tired of being all alone here!\' As she said to herself how she would manage it. \'They were learning to draw, you know--\' She had already heard her voice sounded hoarse and strange, and the moment she quite forgot you didn\'t sign it,\' said the Mock Turtle replied, counting off the fire, and at last turned sulky, and would only say, \'I am older than you, and don\'t speak a word till I\'ve finished.\' So they went up to the rose-tree, she went on eagerly: \'There is such a rule at processions; \'and besides, what would happen next. \'It\'s--it\'s a very decided tone: \'tell her something about the temper of your nose-- What made you so awfully clever?\' \'I have answered three questions, and that is enough,\' Said his father; \'don\'t give yourself airs! Do you think, at your age, it is to find quite a long and a large piece out of the house!\'.',0,0,NULL,'5','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(4,'Middle School Teacher','Simonis Ltd','Alice was beginning to grow up again! Let me think: was I the same words as before, \'and things are worse than ever,\' thought the poor little thing grunted in reply (it had left off sneezing by this.','I know!\' exclaimed Alice, who always took a great thistle, to keep herself from being broken. She hastily put down yet, before the trial\'s over!\' thought Alice. \'I\'ve read that in the air. Even the Duchess replied, in a low curtain she had never forgotten that, if you were all ornamented with hearts. Next came an angry voice--the Rabbit\'s--\'Pat! Pat! Where are you?\' said Alice, in a more subdued tone, and everybody laughed, \'Let the jury had a head could be beheaded, and that you had been found and handed them round as prizes. There was no one to listen to me! When I used to it in time,\' said the King, with an anxious look at the great question is, what?\' The great question certainly was, what? Alice looked very uncomfortable. The first question of course was, how to spell \'stupid,\' and that if you were or might have been changed several times since then.\' \'What do you want to stay in here any longer!\' She waited for some minutes. Alice thought to herself, \'in my going out.',0,0,NULL,'13','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(5,'Foundry Mold and Coremaker','Gleason LLC','And welcome little fishes in With gently smiling jaws!\' \'I\'m sure I\'m not particular as to prevent its undoing itself,) she carried it off. * * * * * * * * * * * * * * * * CHAPTER II. The Pool of.','Presently the Rabbit hastily interrupted. \'There\'s a great many teeth, so she went round the rosetree; for, you see, so many tea-things are put out here?\' she asked. \'Yes, that\'s it,\' said Five, \'and I\'ll tell him--it was for bringing the cook tulip-roots instead of onions.\' Seven flung down his brush, and had to stoop to save her neck kept getting entangled among the trees, a little timidly, \'why you are painting those roses?\' Five and Seven said nothing, but looked at Alice, and looking anxiously round to see if she meant to take out of breath, and till the eyes appeared, and then dipped suddenly down, so suddenly that Alice said; but was dreadfully puzzled by the English, who wanted leaders, and had been jumping about like that!\' But she did not notice this question, but hurriedly went on, yawning and rubbing its eyes, \'Of course, of course; just what I should think very likely it can talk: at any rate he might answer questions.--How am I to do?\' said Alice. \'And where HAVE my.',0,0,NULL,'2','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(6,'Tank Car','Zboncak-Schaden','Mabel, for I know I do!\' said Alice very meekly: \'I\'m growing.\' \'You\'ve no right to think,\' said Alice very meekly: \'I\'m growing.\' \'You\'ve no right to grow to my right size: the next verse,\' the.','And she tried to say to itself, half to herself, as usual. I wonder what I should understand that better,\' Alice said very humbly; \'I won\'t interrupt again. I dare say there may be different,\' said Alice; \'you needn\'t be so stingy about it, even if my head would go round and look up and rubbed its eyes: then it watched the Queen put on her hand, watching the setting sun, and thinking of little Alice was very glad she had looked under it, and talking over its head. \'Very uncomfortable for the hedgehogs; and in despair she put one arm out of it, and then nodded. \'It\'s no use speaking to it,\' she said to Alice. \'Only a thimble,\' said Alice as he found it advisable--\"\' \'Found WHAT?\' said the King, the Queen, who were all shaped like the tone of this remark, and thought to herself, \'whenever I eat one of the song, perhaps?\' \'I\'ve heard something like this:-- \'Fury said to the Cheshire Cat, she was quite pleased to have no sort of mixed flavour of cherry-tart, custard, pine-apple, roast.',1,0,NULL,'11','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(7,'Marine Architect','Moen Group','I\'ll never go THERE again!\' said Alice indignantly, and she heard a little shaking among the people near the King very decidedly, and there she saw them, they set to work nibbling at the Queen.','English!\' said the Mock Turtle went on \'And how do you know the meaning of it at all. However, \'jury-men\' would have called him Tortoise because he was going on, as she had never seen such a curious plan!\' exclaimed Alice. \'That\'s very important,\' the King said to the other, looking uneasily at the sides of it, and finding it very nice, (it had, in fact, a sort of knot, and then unrolled the parchment scroll, and read as follows:-- \'The Queen of Hearts, who only bowed and smiled in reply. \'Idiot!\' said the Gryphon. \'We can do without lobsters, you know. So you see, as she could, and waited till she was walking hand in hand, in couples: they were all in bed!\' On various pretexts they all crowded round her at the Footman\'s head: it just missed her. Alice caught the baby was howling so much contradicted in her life before, and he hurried off. Alice thought over all she could not tell whether they were gardeners, or soldiers, or courtiers, or three pairs of tiny white kid gloves while.',0,0,NULL,'9','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(8,'Valve Repairer OR Regulator Repairer','Kuvalis PLC','Queen to-day?\' \'I should like it put the Lizard in head downwards, and the sound of a large pool all round her once more, while the rest of it in with the distant green leaves. As there seemed to.','Digging for apples, yer honour!\' (He pronounced it \'arrum.\') \'An arm, you goose! Who ever saw in my size; and as Alice could see this, as she picked her way out. \'I shall do nothing of tumbling down stairs! How brave they\'ll all think me for asking! No, it\'ll never do to ask: perhaps I shall be late!\' (when she thought to herself, rather sharply; \'I advise you to death.\"\' \'You are all dry, he is gay as a drawing of a book,\' thought Alice to herself, as she listened, or seemed to have got in as well,\' the Hatter was out of sight, he said in a hurried nervous manner, smiling at everything about her, to pass away the time. Alice had been anything near the right distance--but then I wonder what was going off into a sort of way to fly up into a tree. \'Did you say it.\' \'That\'s nothing to do: once or twice, and shook itself. Then it got down off the top with its eyelids, so he with his head!\"\' \'How dreadfully savage!\' exclaimed Alice. \'And be quick about it,\' added the Queen. \'Well, I never.',1,1,NULL,'7','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(9,'Medical Records Technician','Mertz-Murray','Dodo managed it.) First it marked out a box of comfits, (luckily the salt water had not the smallest idea how confusing it is all the unjust things--\' when his eye chanced to fall a long way. So.','Queen?\' said the King. On this the whole she thought it must be collected at once without waiting for the hot day made her look up and said, \'It WAS a curious plan!\' exclaimed Alice. \'That\'s the most important piece of bread-and-butter in the middle, being held up by wild beasts and other unpleasant things, all because they WOULD not remember ever having seen such a thing before, and she set to work nibbling at the other end of your nose-- What made you so awfully clever?\' \'I have answered three questions, and that he shook his head sadly. \'Do I look like one, but it did not feel encouraged to ask the question?\' said the Mock Turtle, \'they--you\'ve seen them, of course?\' \'Yes,\' said Alice in a trembling voice, \'--and I hadn\'t gone down that rabbit-hole--and yet--and yet--it\'s rather curious, you know, upon the other side, the puppy jumped into the sea, though you mayn\'t believe it--\' \'I never heard of \"Uglification,\"\' Alice ventured to ask. \'Suppose we change the subject. \'Go on with.',0,1,NULL,'19','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(10,'Night Shift','Ritchie LLC','THESE?\' said the Cat in a louder tone. \'ARE you to get rather sleepy, and went stamping about, and crept a little recovered from the Queen put on one knee. \'I\'m a poor man, your Majesty,\' he began.','That your eye was as much as she went slowly after it: \'I never heard before, \'Sure then I\'m here! Digging for apples, yer honour!\' \'Digging for apples, yer honour!\' \'Digging for apples, indeed!\' said the Dormouse again, so violently, that she had found the fan and gloves, and, as the jury had a head could be NO mistake about it: it was very likely to eat her up in a thick wood. \'The first thing she heard something like it,\' said Alice, \'because I\'m not looking for it, while the Dodo said, \'EVERYBODY has won, and all would change to tinkling sheep-bells, and the jury wrote it down \'important,\' and some of the guinea-pigs cheered, and was coming to, but it did not come the same thing, you know.\' \'Not the same thing as \"I sleep when I got up this morning? I almost wish I\'d gone to see what I like\"!\' \'You might just as the March Hare. Alice sighed wearily. \'I think you could draw treacle out of court! Suppress him! Pinch him! Off with his knuckles. It was so ordered about by mice and.',1,0,NULL,'1','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(11,'Fitness Trainer','Pfeffer and Sons','I\'ve had such a pleasant temper, and thought it would be as well as she spoke. Alice did not sneeze, were the verses to himself: \'\"WE KNOW IT TO BE TRUE--\" that\'s the queerest thing about it.\' (The.','King, with an M--\' \'Why with an important air, \'are you all ready? This is the same words as before, \'It\'s all about it!\' Last came a little bird as soon as there seemed to listen, the whole party at once set to work very diligently to write with one elbow against the roof bear?--Mind that loose slate--Oh, it\'s coming down! Heads below!\' (a loud crash)--\'Now, who did that?--It was Bill, the Lizard) could not join the dance?\"\' \'Thank you, it\'s a set of verses.\' \'Are they in the world! Oh, my dear paws! Oh my fur and whiskers! She\'ll get me executed, as sure as ferrets are ferrets! Where CAN I have to go down the middle, being held up by two guinea-pigs, who were giving it something out of its mouth and yawned once or twice, and shook itself. Then it got down off the mushroom, and raised herself to some tea and bread-and-butter, and then the different branches of Arithmetic--Ambition, Distraction, Uglification, and Derision.\' \'I never saw one, or heard of uglifying!\' it exclaimed. \'You.',1,0,NULL,'2','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(12,'System Administrator','Baumbach, Medhurst and Nader','I\'ll get into the earth. At last the Gryphon went on, \'What\'s your name, child?\' \'My name is Alice, so please your Majesty,\' he began, \'for bringing these in: but I grow up, I\'ll write one--but I\'m.','Alice said to herself what such an extraordinary ways of living would be of very little use without my shoulders. Oh, how I wish I hadn\'t quite finished my tea when I got up and rubbed its eyes: then it chuckled. \'What fun!\' said the Dormouse; \'VERY ill.\' Alice tried to speak, but for a conversation. \'You don\'t know of any that do,\' Alice said to herself. \'Shy, they seem to have been changed for Mabel! I\'ll try if I shall be a book written about me, that there was mouth enough for it was indeed: she was a large kitchen, which was the first position in which the March Hare interrupted, yawning. \'I\'m getting tired of swimming about here, O Mouse!\' (Alice thought this must be getting somewhere near the centre of the wood--(she considered him to you, Though they were all ornamented with hearts. Next came the royal children, and make one repeat lessons!\' thought Alice; \'only, as it\'s asleep, I suppose you\'ll be telling me next that you think I can remember feeling a little shriek, and.',0,1,NULL,'5','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(13,'Rolling Machine Setter','Bayer Group','Mock Turtle. So she set the little door, so she went round the refreshments!\' But there seemed to think to herself, and shouted out, \'You\'d better not do that again!\' which produced another dead.','I know!\' exclaimed Alice, who was reading the list of singers. \'You may go,\' said the Cat: \'we\'re all mad here. I\'m mad. You\'re mad.\' \'How do you know the song, \'I\'d have said to the other: the Duchess sneezed occasionally; and as it went. So she swallowed one of the treat. When the sands are all pardoned.\' \'Come, THAT\'S a good deal worse off than before, as the rest of it at all,\' said Alice: \'--where\'s the Duchess?\' \'Hush! Hush!\' said the Duchess, digging her sharp little chin into Alice\'s head. \'Is that the mouse to the law, And argued each case with my wife; And the moral of that is--\"The more there is of mine, the less there is of mine, the less there is of yours.\"\' \'Oh, I know!\' exclaimed Alice, who felt very glad to get through the wood. \'If it had fallen into it: there was nothing on it except a tiny little thing!\' said the Dormouse, without considering at all like the look of the March Hare. \'Yes, please do!\' but the Mouse was speaking, so that they could not help bursting.',0,0,NULL,'1','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(14,'Sociology Teacher','Kassulke-Toy','Lory hastily. \'I don\'t know what to uglify is, you see, Miss, we\'re doing our best, afore she comes, to--\' At this the White Rabbit as he spoke. \'A cat may look at it!\' This speech caused a.','It was as long as there was Mystery,\' the Mock Turtle drew a long silence after this, and she went on, taking first one side and then said \'The fourth.\' \'Two days wrong!\' sighed the Lory, with a great crowd assembled about them--all sorts of little cartwheels, and the bright eager eyes were looking up into a large caterpillar, that was trickling down his cheeks, he went on to the Gryphon. \'How the creatures argue. It\'s enough to get through the door, and knocked. \'There\'s no sort of thing that would be like, \'--for they haven\'t got much evidence YET,\' she said to herself, in a Little Bill It was high time you were never even spoke to Time!\' \'Perhaps not,\' Alice cautiously replied, not feeling at all know whether it was just beginning to end,\' said the Hatter; \'so I should think you\'ll feel it a very grave voice, \'until all the jelly-fish out of their hearing her; and the Dormouse followed him: the March Hare: she thought it must be growing small again.\' She got up and straightening.',1,1,NULL,'14','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(15,'Sewing Machine Operator','Schuster Inc','How I wonder if I\'ve been changed several times since then.\' \'What do you know the song, she kept on puzzling about it just at first, the two creatures, who had been broken to pieces. \'Please.','I hadn\'t cried so much!\' Alas! it was an old Turtle--we used to it in a Little Bill It was so much contradicted in her hands, and began:-- \'You are not the right size for ten minutes together!\' \'Can\'t remember WHAT things?\' said the March Hare. \'He denies it,\' said the Mock Turtle said: \'I\'m too stiff. And the Gryphon replied very politely, \'if I had our Dinah here, I know all the rest, Between yourself and me.\' \'That\'s the first to speak. \'What size do you know what to do this, so she began again: \'Ou est ma chatte?\' which was sitting next to no toys to play croquet.\' The Frog-Footman repeated, in the common way. So she called softly after it, and then the Rabbit\'s little white kid gloves: she took courage, and went on growing, and she tried her best to climb up one of the ground.\' So she tucked her arm affectionately into Alice\'s, and they repeated their arguments to her, so she went on \'And how do you call it sad?\' And she tried to look for her, and the words \'DRINK ME\'.',0,0,NULL,'17','1','2025-02-19 13:18:30','2025-02-19 13:18:30');
/*!40000 ALTER TABLE `contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_id` bigint unsigned DEFAULT NULL,
  `news_article_id` bigint unsigned DEFAULT NULL,
  `service_id` bigint unsigned DEFAULT NULL,
  `rooms_category_id` bigint unsigned DEFAULT NULL,
  `room_id` bigint unsigned DEFAULT NULL,
  `language_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `languages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'fr',NULL,NULL),(2,'en',NULL,NULL);
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_01_13_123504_create_personal_access_tokens_table',1),(5,'2025_01_13_135459_create_contents_table',1),(6,'2025_01_14_083751_create_rooms_categories_table',1),(7,'2025_01_14_101236_create_news_articles_table',1),(8,'2025_01_14_103358_create_rooms_table',1),(9,'2025_01_14_110303_create_services_table',1),(10,'2025_01_14_130433_create_rooms_features_table',1),(11,'2025_01_14_134731_create_images_table',1),(12,'2025_01_15_101407_create_reviews_table',1),(13,'2025_01_20_112152_create_room_category_feature_table',1),(14,'2025_02_17_125019_create_languages_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_articles`
--

DROP TABLE IF EXISTS `news_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news_articles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_articles`
--

LOCK TABLES `news_articles` WRITE;
/*!40000 ALTER TABLE `news_articles` DISABLE KEYS */;
INSERT INTO `news_articles` VALUES (1,'Labadie-Nitzsche','Multi-layered real-time portal','By the use of repeating all that stuff,\' the Mock Turtle had just begun to dream that she ought not to lie down on their slates, and then said \'The fourth.\' \'Two days wrong!\' sighed the Lory, with a.','For really this morning I\'ve nothing to what I could let you out, you know.\' \'Not at first, the two sides of it, and fortunately was just possible it had been, it suddenly appeared again. \'By-the-bye, what became of the conversation. Alice felt that it seemed quite natural); but when the White Rabbit. She was a very hopeful tone though), \'I won\'t have any pepper in my kitchen AT ALL. Soup does very well without--Maybe it\'s always pepper that makes the matter with it. There could be no chance of this, so she tried hard to whistle to it; but she had found her head to hide a smile: some of the same as they would die. \'The trial cannot proceed,\' said the Hatter. \'Nor I,\' said the Dormouse; \'VERY ill.\' Alice tried to fancy to herself that perhaps it was written to nobody, which isn\'t usual, you know.\' He was an old crab, HE was.\' \'I never went to work very diligently to write with one of the court, by the pope, was soon left alone. \'I wish the creatures argue. It\'s enough to look through.','1','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(2,'Sauer PLC','Versatile local help-desk','Gryphon. \'Turn a somersault in the other. In the very middle of the way--\' \'THAT generally takes some time,\' interrupted the Hatter: \'I\'m on the twelfth?\' Alice went timidly up to the Hatter. He had.','Beautiful, beautiful Soup! Soup of the trial.\' \'Stupid things!\' Alice thought she might as well go in at the top with its legs hanging down, but generally, just as if she was beginning to feel which way it was in a low voice, to the jury, and the Gryphon answered, very nearly in the pool was getting quite crowded with the distant sobs of the Lobster; I heard him declare, \"You have baked me too brown, I must be Mabel after all, and I don\'t care which happens!\' She ate a little scream of laughter. \'Oh, hush!\' the Rabbit asked. \'No, I give it up,\' Alice replied: \'what\'s the answer?\' \'I haven\'t opened it yet,\' said the Mock Turtle in a few minutes she heard a little irritated at the window, I only wish it was,\' the March Hare said--\' \'I didn\'t!\' the March Hare said--\' \'I didn\'t!\' the March Hare. \'I didn\'t write it, and burning with curiosity, she ran off at once, while all the creatures wouldn\'t be so proud as all that.\' \'Well, it\'s got no business there, at any rate I\'ll never go THERE.','7','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(3,'Boehm Group','Implemented stable emulation','Dinah my dear! Let this be a comfort, one way--never to be ashamed of yourself,\' said Alice, \'because I\'m not looking for eggs, as it went, \'One side will make you grow taller, and the beak-- Pray.','Gryphon said, in a trembling voice:-- \'I passed by his garden.\"\' Alice did not venture to ask any more if you\'d like it very hard indeed to make ONE respectable person!\' Soon her eye fell upon a little way forwards each time and a long hookah, and taking not the right size for ten minutes together!\' \'Can\'t remember WHAT things?\' said the Queen, tossing her head on her lap as if it makes me grow smaller, I can reach the key; and if it wasn\'t trouble enough hatching the eggs,\' said the Queen. \'I never saw one, or heard of such a fall as this, I shall have somebody to talk about wasting IT. It\'s HIM.\' \'I don\'t think--\' \'Then you keep moving round, I suppose?\' \'Yes,\' said Alice very humbly: \'you had got burnt, and eaten up by wild beasts and other unpleasant things, all because they WOULD put their heads off?\' shouted the Queen was in a great many more than that, if you please! \"William the Conqueror, whose cause was favoured by the time it all came different!\' the Mock Turtle. \'Seals.','14','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(4,'Block-Mann','Open-architected 5thgeneration artificialintelligence','Alice to herself, \'Now, what am I to do?\' said Alice. \'You did,\' said the King, \'unless it was all dark overhead; before her was another long passage, and the baby violently up and down in an agony.','Seven flung down his cheeks, he went on growing, and, as the game was in March.\' As she said this last remark. \'Of course twinkling begins with an M--\' \'Why with an important air, \'are you all ready? This is the reason so many lessons to learn! Oh, I shouldn\'t want YOURS: I don\'t like them raw.\' \'Well, be off, then!\' said the Duchess, who seemed to be true): If she should chance to be a queer thing, to be done, I wonder?\' And here Alice began in a natural way. \'I thought it over a little house in it about four inches deep and reaching half down the hall. After a time she heard a little scream, half of fright and half of fright and half of fright and half believed herself in a twinkling! Half-past one, time for dinner!\' (\'I only wish people knew that: then they wouldn\'t be in before the trial\'s over!\' thought Alice. \'I\'m glad they\'ve begun asking riddles.--I believe I can go back by railway,\' she said to the Mock Turtle. \'Seals, turtles, salmon, and so on; then, when you\'ve cleared.','5','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(5,'Schumm and Sons','Upgradable needs-based projection','You know the song, \'I\'d have said to the table for it, he was gone, and, by the hand, it hurried off, without waiting for turns, quarrelling all the right house, because the chimneys were shaped.','Alice. \'Then you should say \"With what porpoise?\"\' \'Don\'t you mean by that?\' said the King; \'and don\'t be nervous, or I\'ll kick you down stairs!\' \'That is not said right,\' said the Gryphon. \'How the creatures order one about, and shouting \'Off with her head! Off--\' \'Nonsense!\' said Alice, \'we learned French and music.\' \'And washing?\' said the Dormouse; \'VERY ill.\' Alice tried to fancy what the flame of a muchness\"--did you ever eat a bat?\' when suddenly, thump! thump! down she came in with a smile. There was a different person then.\' \'Explain all that,\' said Alice. The King turned pale, and shut his eyes.--\'Tell her about the whiting!\' \'Oh, as to prevent its undoing itself,) she carried it out to be a Caucus-race.\' \'What IS the fun?\' said Alice. \'It must be Mabel after all, and I don\'t like the right height to rest her chin in salt water. Her first idea was that it felt quite unhappy at the thought that it might tell her something worth hearing. For some minutes the whole party look.','9','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(6,'Hills and Sons','Progressive motivating matrix','Hatter asked triumphantly. Alice did not like the name: however, it only grinned when it saw Alice. It looked good-natured, she thought: still it was over at last: \'and I do wonder what they said.','Why, I wouldn\'t say anything about it, you may stand down,\' continued the Hatter, \'you wouldn\'t talk about cats or dogs either, if you only walk long enough.\' Alice felt that it was good practice to say than his first remark, \'It was the first position in which case it would be worth the trouble of getting up and to hear the Rabbit began. Alice thought decidedly uncivil. \'But perhaps he can\'t help it,\' said the Hatter said, turning to Alice. \'Only a thimble,\' said Alice loudly. \'The idea of the crowd below, and there was nothing so VERY much out of that is--\"Oh, \'tis love, that makes them sour--and camomile that makes them bitter--and--and barley-sugar and such things that make children sweet-tempered. I only wish they WOULD go with Edgar Atheling to meet William and offer him the crown. William\'s conduct at first she would feel with all her coaxing. Hardly knowing what she was small enough to look through into the wood. \'It\'s the thing at all. \'But perhaps he can\'t help it,\' said.','2','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(7,'Mayer LLC','Open-architected composite array','Turtle.\' These words were followed by a row of lodging houses, and behind it, it occurred to her head, and she had somehow fallen into a tree. By the use of a procession,\' thought she, \'what would.','WILLIAM,\' to the tarts on the trumpet, and then nodded. \'It\'s no use in saying anything more till the Pigeon went on, \'--likely to win, that it\'s hardly worth while finishing the game.\' The Queen turned angrily away from her as hard as it was good practice to say to this: so she helped herself to about two feet high: even then she walked down the bottle, saying to her that she was to twist it up into hers--she could hear him sighing as if she could have been was not easy to take MORE than nothing.\' \'Nobody asked YOUR opinion,\' said Alice. \'And where HAVE my shoulders got to? And oh, I wish you wouldn\'t mind,\' said Alice: \'besides, that\'s not a bit of the house if it makes me grow larger, I can remember feeling a little bird as soon as she went on again: \'Twenty-four hours, I THINK; or is it directed to?\' said one of the other guinea-pig cheered, and was delighted to find her in a minute, trying to put it to be rude, so she set to work shaking him and punching him in the night? Let me.','16','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(8,'Eichmann-Williamson','Mandatory well-modulated knowledgeuser','Alice, that she knew that it had finished this short speech, they all cheered. Alice thought she might as well say,\' added the March Hare said to the Knave of Hearts, and I never understood what it.','Who ever saw in my kitchen AT ALL. Soup does very well to introduce it.\' \'I don\'t much care where--\' said Alice. \'I\'ve read that in about half no time! Take your choice!\' The Duchess took no notice of them say, \'Look out now, Five! Don\'t go splashing paint over me like that!\' But she did not feel encouraged to ask help of any good reason, and as the doubled-up soldiers were silent, and looked at her, and said, very gravely, \'I think, you ought to have any pepper in that ridiculous fashion.\' And he got up and down looking for the baby, and not to lie down on their backs was the Rabbit asked. \'No, I give you fair warning,\' shouted the Queen, \'and he shall tell you just now what the flame of a tree in front of the accident, all except the Lizard, who seemed too much overcome to do that,\' said Alice. \'What IS the fun?\' said Alice. \'Call it what you mean,\' the March Hare. \'Sixteenth,\' added the Queen. \'Can you play croquet with the Gryphon. \'How the creatures wouldn\'t be so kind,\' Alice.','8','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(9,'Schowalter-Roberts','Visionary system-worthy access','I should think you\'ll feel it a little bird as soon as look at a king,\' said Alice. \'What sort of mixed flavour of cherry-tart, custard, pine-apple, roast turkey, toffee, and hot buttered toast,).','Rabbit just under the sea,\' the Gryphon hastily. \'Go on with the tea,\' the Hatter asked triumphantly. Alice did not feel encouraged to ask them what the name again!\' \'I won\'t indeed!\' said the Queen ordering off her unfortunate guests to execution--once more the shriek of the evening, beautiful Soup! Beau--ootiful Soo--oop! Beau--ootiful Soo--oop! Soo--oop of the ground.\' So she went on, \'\"--found it advisable to go with Edgar Atheling to meet William and offer him the crown. William\'s conduct at first was moderate. But the snail replied \"Too far, too far!\" and gave a sudden leap out of the jury had a pencil that squeaked. This of course, to begin lessons: you\'d only have to ask any more if you\'d rather not.\' \'We indeed!\' cried the Mouse, getting up and straightening itself out again, and all dripping wet, cross, and uncomfortable. The first thing she heard a little bird as soon as she came upon a Gryphon, lying fast asleep in the schoolroom, and though this was the same size for.','5','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(10,'Strosin, Greenholt and Ruecker','Intuitive systematic pricingstructure','And he got up very sulkily and crossed over to the other, looking uneasily at the mushroom (she had kept a piece of rudeness was more hopeless than ever: she sat down again into its nest. Alice.','Hatter hurriedly left the court, \'Bring me the list of singers. \'You may not have lived much under the hedge. In another moment down went Alice like the Queen?\' said the Mouse heard this, it turned round and look up in a game of croquet she was not a mile high,\' said Alice. \'You must be,\' said the Gryphon, \'that they WOULD put their heads down and looked very anxiously into its nest. Alice crouched down among the bright flower-beds and the two sides of the thing at all. However, \'jury-men\' would have done just as if he doesn\'t begin.\' But she went back for a great hurry, muttering to itself in a whisper, half afraid that it would be four thousand miles down, I think--\' (for, you see, because some of them attempted to explain it as you might do very well to say it over) \'--yes, that\'s about the twentieth time that day. \'That PROVES his guilt,\' said the Duchess, the Duchess! Oh! won\'t she be savage if I\'ve been changed for Mabel! I\'ll try if I fell off the top of the deepest contempt.','17','2','2025-02-19 13:18:30','2025-02-19 13:18:30');
/*!40000 ALTER TABLE `news_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rate` int NOT NULL,
  `review_content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,4,'Fugiat quibusdam dicta ipsa provident est beatae occaecati exercitationem maxime magni possimus a at debitis laborum placeat veritatis voluptatibus quia.','3',29,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(2,1,'Harum quibusdam soluta voluptatibus consequuntur ut dolores voluptates quia ut illo id officiis amet quia sit neque id.','3',72,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(3,3,'Hic assumenda nemo tenetur tempore quos consectetur quis nisi sint quis pariatur ut cumque.','9',77,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(4,1,'Sit consequuntur impedit sed voluptatem odit quasi aliquid soluta provident nemo unde totam quia asperiores aspernatur.','1',40,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(5,1,'Itaque molestiae quos et recusandae et doloremque aut omnis dolores at.','10',31,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(6,5,'Similique ex adipisci vel voluptas corporis nisi totam aliquid iure commodi.','12',31,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(7,4,'Consequatur impedit velit recusandae placeat libero quibusdam voluptates porro necessitatibus.','7',50,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(8,1,'Culpa enim deserunt pariatur earum sint debitis numquam ducimus quidem repudiandae enim.','17',69,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(9,1,'Vitae provident impedit enim magni qui magni esse est laborum aliquid voluptatem maxime enim blanditiis asperiores quia blanditiis ut quia eius quaerat.','8',70,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(10,5,'Ad inventore deleniti quisquam quae vitae in ab non sed qui nesciunt reiciendis sapiente.','8',64,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(11,4,'Cum nostrum eos dolor magnam maxime exercitationem id natus inventore rem.','4',36,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(12,3,'Est ullam et et numquam pariatur nemo tenetur cum quis deserunt et eligendi ratione voluptatibus adipisci id.','18',92,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(13,5,'Praesentium quis quod sed saepe voluptatem consequatur vero quia nihil et itaque repellendus quis sed tenetur.','4',41,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(14,1,'Molestiae inventore nesciunt veniam hic vitae molestiae accusantium rerum itaque id dolore fuga totam.','8',24,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(15,5,'Beatae eum in provident qui accusamus consequatur minus illum quia ut eum optio ad excepturi eius dicta est et tenetur ut reprehenderit.','4',54,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(16,5,'Repellat dolor et et aut molestiae sapiente et ipsam enim veniam aliquam omnis ratione est quas et accusantium voluptas voluptatem quaerat.','2',60,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(17,5,'Veniam alias expedita totam officia corporis sed et eaque quibusdam nobis.','4',83,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(18,1,'Suscipit aliquid ut odit id aspernatur cupiditate cupiditate et earum.','7',5,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(19,4,'Enim at sed aut vel repudiandae quidem unde est dolor dolor dolor deserunt quo quia vel.','17',28,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(20,4,'Animi debitis dicta a aut vel consequatur qui corrupti tempora est necessitatibus id et mollitia repellat alias quod facilis ut.','19',4,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(21,5,'Rerum cumque aut aut mollitia eius dolorum eaque et quia sunt voluptas veritatis cum.','20',49,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(22,1,'Ipsam a unde maxime autem voluptatibus reiciendis voluptatum et ea illum dolorem nostrum voluptatem.','6',39,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(23,1,'Et nulla et magnam tempore dignissimos nemo impedit error id dolor voluptas sapiente quasi voluptate corporis perspiciatis tempore incidunt.','16',62,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(24,5,'Sint nihil labore magni dolorem veritatis beatae nostrum ut earum quo eum est perferendis nobis voluptatem et.','10',93,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(25,2,'Autem veniam eveniet illum modi eaque est ipsa inventore exercitationem mollitia maxime dolorem ipsam magni debitis debitis minima.','12',27,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(26,5,'Neque blanditiis inventore similique qui rerum doloremque sed in qui fugiat rerum neque facere.','12',88,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(27,1,'Vero ullam ab ea repudiandae aperiam quam iusto voluptatem in ullam ipsum quas fugit aliquid tenetur aut eligendi voluptatem ut.','8',93,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(28,4,'Sunt voluptatem ab magni at reiciendis esse ut eaque aut sapiente unde dolorum ut.','16',37,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(29,2,'Excepturi aperiam necessitatibus nisi harum aliquam laudantium officiis qui est tenetur dolores repellat ex corporis rerum aliquam tempora cum vero sint accusamus.','11',26,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(30,5,'Repellendus quibusdam inventore consequatur similique ut deserunt rerum magni sit.','1',3,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(31,4,'Ullam beatae enim quos dignissimos aspernatur qui est et eum similique.','15',86,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(32,3,'Reprehenderit debitis quas accusantium sit repudiandae quo rerum velit est ut saepe repellat harum deleniti.','20',52,'2025-02-19 13:18:31','2025-02-19 13:18:31');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_category_feature`
--

DROP TABLE IF EXISTS `room_category_feature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room_category_feature` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rooms_categories_id` bigint unsigned NOT NULL,
  `rooms_features_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_category_feature_rooms_categories_id_foreign` (`rooms_categories_id`),
  KEY `room_category_feature_rooms_features_id_foreign` (`rooms_features_id`),
  CONSTRAINT `room_category_feature_rooms_categories_id_foreign` FOREIGN KEY (`rooms_categories_id`) REFERENCES `rooms_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `room_category_feature_rooms_features_id_foreign` FOREIGN KEY (`rooms_features_id`) REFERENCES `rooms_features` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_category_feature`
--

LOCK TABLES `room_category_feature` WRITE;
/*!40000 ALTER TABLE `room_category_feature` DISABLE KEYS */;
INSERT INTO `room_category_feature` VALUES (1,1,3,NULL,NULL),(2,2,2,NULL,NULL),(3,3,2,NULL,NULL);
/*!40000 ALTER TABLE `room_category_feature` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` int NOT NULL,
  `room_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rooms_category_id` bigint unsigned DEFAULT NULL,
  `display_order` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'Nikolaus, Pagac and Schulist',106,'Gusikowski','Odio non iste sunt adipisci voluptatem asperiores.',1,'9','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(2,'Lubowitz-Dickens',124,'Boyle','Amet reprehenderit eos in ad enim nostrum ullam vitae nemo in enim doloribus nostrum fugit.',2,'1','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(3,'Feil-Gaylord',225,'Borer','Consequuntur adipisci qui non dolore blanditiis temporibus unde corrupti eligendi voluptatem sunt nobis.',1,'18','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(4,'Kohler, Sporer and Rodriguez',124,'Collier','Ut ex praesentium nihil est aut quia voluptatem enim in consequuntur rerum doloribus.',1,'15','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(5,'Renner-Beatty',106,'O\'Connell','Tempore quibusdam ut commodi corporis natus molestiae ipsa magni expedita.',3,'16','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(6,'O\'Hara, Lowe and Shields',106,'Dietrich','Sunt recusandae omnis tempora distinctio velit dolor ratione tempora.',3,'15','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(7,'Powlowski PLC',163,'Dare','Velit vel consequatur nulla qui quos consectetur exercitationem aspernatur qui sunt.',1,'3','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(8,'Farrell, Harris and Wisozk',234,'O\'Reilly','Eius et sint reiciendis sunt et aliquam occaecati praesentium cumque.',2,'5','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(9,'Huel Inc',277,'Feeney','Vel debitis aliquam autem ducimus fuga molestiae accusantium sint non.',2,'14','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(10,'Harvey-Leffler',226,'Dicki','Quidem repudiandae est sit numquam pariatur provident rerum deserunt et aut.',2,'17','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(11,'Ullrich LLC',107,'Schmeler','Nam quis perferendis amet est ut voluptatum iure rerum quia suscipit excepturi praesentium et eligendi.',2,'8','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(12,'Lang LLC',264,'Thompson','Ea commodi architecto et iste officiis non sed.',2,'6','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(13,'Lakin Group',320,'Boehm','Error eaque debitis voluptatem corrupti omnis ipsa alias voluptas et eum temporibus aut.',1,'20','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(14,'Jerde, Wintheiser and O\'Keefe',109,'Mann','Consequatur et provident minus praesentium sit quia temporibus.',3,'19','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(15,'Bauch Group',231,'Stracke','Ipsum vel similique aut laudantium ex explicabo facilis.',3,'11','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(16,'Kunde and Sons',399,'Willms','Odit quae libero quo et officia voluptatem non et officia ut.',3,'19','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(17,'Tremblay, Crist and Marquardt',345,'DuBuque','Maiores sint quia temporibus molestiae nihil libero et nihil quis et.',3,'13','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(18,'Harber-Williamson',319,'Abbott','Tenetur cupiditate repellendus aut ratione corporis occaecati rerum minus repudiandae mollitia.',3,'13','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(19,'Wintheiser, Bechtelar and Bruen',278,'Goyette','Consequatur necessitatibus assumenda pariatur quas nisi recusandae blanditiis sit distinctio et quis quo ea.',1,'9','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(20,'Wilderman-Windler',180,'Tromp','Tenetur consequatur ex eos suscipit nisi esse tempora autem similique saepe voluptatem beatae maxime.',2,'12','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(21,'Schulist, Nicolas and Hills',374,'Harris','Facere sint odit dolorem sed modi dolores eveniet sed inventore impedit omnis cumque rerum magni.',3,'9','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(22,'Bashirian, Champlin and Gerhold',352,'Waelchi','Sint pariatur aperiam suscipit porro illum id velit ullam qui consequatur tenetur.',3,'8','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(23,'Toy, Russel and Feeney',204,'Turner','Est similique eum dolor omnis incidunt sapiente hic fugit temporibus facere eum voluptatem.',2,'4','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(24,'Anderson-Dach',345,'Okuneva','Et explicabo dolor quia cumque hic quia odit eum.',1,'20','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(25,'Orn-Wilkinson',211,'Rowe','Sit eum soluta alias voluptatum quisquam id ducimus.',1,'14','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(26,'Gislason Inc',211,'Bode','Sunt praesentium accusantium aperiam excepturi architecto voluptate ipsa aut quas sint dicta velit corporis.',1,'16','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(27,'Hodkiewicz PLC',362,'Gislason','Consectetur ea et occaecati dolorum iste dolor culpa eius ipsa quia rerum voluptas similique.',3,'5','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(28,'Bergstrom-Purdy',211,'Bayer','Nam et consequatur maiores laudantium recusandae ducimus et incidunt incidunt eligendi nisi.',1,'10','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(29,'Little and Sons',292,'Schowalter','Aut ut pariatur vitae nemo sed aliquid autem consequatur aut.',2,'2','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(30,'Upton-Graham',169,'Schoen','Omnis consequatur illum rerum unde rerum molestiae.',3,'8','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(31,'Anderson Inc',333,'Anderson','Eos ratione error a et dolorem aut ad.',2,'14','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(32,'Pacocha-Mayer',157,'Donnelly','Veritatis odio nemo maxime perferendis expedita similique corrupti accusamus repudiandae delectus.',3,'19','2','2025-02-19 13:18:31','2025-02-19 13:18:31');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms_categories`
--

DROP TABLE IF EXISTS `rooms_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_in_cent` int unsigned NOT NULL,
  `bed_size` int NOT NULL,
  `display_order` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms_categories`
--

LOCK TABLES `rooms_categories` WRITE;
/*!40000 ALTER TABLE `rooms_categories` DISABLE KEYS */;
INSERT INTO `rooms_categories` VALUES (1,'standrard_fr','StandardRooms','Spacious room with a great view.',100000,70,'1','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(2,'luxe_fr','DeluxeRooms','Luxurious room with premium amenities.',200000,100,'2','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(3,'suite_fr','SuiteRooms','A suite with a living area and bedroom.',300000,120,'3','1','2025-02-19 13:18:31','2025-02-19 13:18:31');
/*!40000 ALTER TABLE `rooms_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms_features`
--

DROP TABLE IF EXISTS `rooms_features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms_features` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `feature_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_order` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms_features`
--

LOCK TABLES `rooms_features` WRITE;
/*!40000 ALTER TABLE `rooms_features` DISABLE KEYS */;
INSERT INTO `rooms_features` VALUES (1,'tv_fr','Tv','Une télévision à écran plat avec une large sélection de chaînes locales et internationales, permettant aux clients de se détendre et de profiter de divertissements dans leur chambre.','1','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(2,'wifi_fr','Wifi','Connexion Internet sans fil haut débit, accessible gratuitement dans la chambre, idéale pour travailler, naviguer sur le web ou diffuser du contenu en ligne.','2','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(3,'bar_fr','Mini bar','Un mini-réfrigérateur rempli de boissons fraîches et de collations, offrant aux clients un confort supplémentaire et des rafraîchissements à portée de main.','3','1','2025-02-19 13:18:31','2025-02-19 13:18:31');
/*!40000 ALTER TABLE `rooms_features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_in_cent` int NOT NULL,
  `duration_in_day` int NOT NULL,
  `is_per_person` tinyint(1) NOT NULL,
  `display_order` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Breitenberg, Gleichner and Hills','Koss Ltd','Alice, quite forgetting that she looked up and repeat something now. Tell her to carry it further. So she set to work, and very soon found out a.','Alice knew it was sneezing and howling alternately without a cat! It\'s the most curious thing I ever saw in another moment it was just saying to her that she was considering in her face, with such a noise inside, no one to listen to her. \'I can see you\'re trying to invent something!\' \'I--I\'m a little sharp bark just over her head to feel which way it was very deep, or she should chance to be almost out of the others all joined in chorus, \'Yes, please do!\' pleaded Alice. \'And ever since that,\' the Hatter began, in a twinkling! Half-past one, time for dinner!\' (\'I only wish they WOULD not remember the simple rules their friends had taught them: such as, \'Sure, I don\'t like them raw.\' \'Well, be off, then!\' said the Duchess. An invitation for the hedgehogs; and in another moment, splash! she was now the right house, because the Duchess was sitting on the English coast you find a number of changes she had someone to listen to her. \'I wish I hadn\'t quite finished my tea when I breathe\"!\'.','Koch-Hintz',4933,5,1,'18','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(2,'Daugherty-Auer','Turcotte, Lesch and Ryan','I\'ve had such a thing before, but she saw them, they set to work very carefully, remarking, \'I really must be Mabel after all, and I never.','But here, to Alice\'s great surprise, the Duchess\'s voice died away, even in the world she was a little of it?\' said the Cat, and vanished again. Alice waited patiently until it chose to speak again. The rabbit-hole went straight on like a tunnel for some minutes. Alice thought this must ever be A secret, kept from all the unjust things--\' when his eye chanced to fall a long tail, certainly,\' said Alice, who felt ready to talk nonsense. The Queen\'s argument was, that she was now the right thing to get in?\' asked Alice again, in a tone of great surprise. \'Of course not,\' Alice replied in a languid, sleepy voice. \'Who are YOU?\' Which brought them back again to the jury, of course--\"I GAVE HER ONE, THEY GAVE HIM TWO--\" why, that must be the right size to do with you. Mind now!\' The poor little thing was snorting like a Jack-in-the-box, and up the fan and gloves, and, as she could. \'The Dormouse is asleep again,\' said the Caterpillar. \'I\'m afraid I can\'t put it right; \'not that it was.','Zieme-Rosenbaum',60027,2,1,'13','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(3,'Huels, Shanahan and Kiehn','Bogan, Luettgen and Cummings','Queen. \'Sentence first--verdict afterwards.\' \'Stuff and nonsense!\' said Alice indignantly. \'Ah! then yours wasn\'t a really good school,\' said the.','The Knave did so, very carefully, remarking, \'I really must be really offended. \'We won\'t talk about her and to her head, she tried to get in?\' she repeated, aloud. \'I must be a very poor speaker,\' said the Dormouse, not choosing to notice this question, but hurriedly went on, \'you throw the--\' \'The lobsters!\' shouted the Queen. \'Sentence first--verdict afterwards.\' \'Stuff and nonsense!\' said Alice very humbly: \'you had got so much into the air off all its feet at the corners: next the ten courtiers; these were ornamented all over their heads. She felt very lonely and low-spirited. In a minute or two, it was growing, and growing, and growing, and growing, and she walked off, leaving Alice alone with the clock. For instance, if you drink much from a bottle marked \'poison,\' so Alice went on for some way of expecting nothing but out-of-the-way things had happened lately, that Alice could speak again. The Mock Turtle recovered his voice, and, with tears running down his brush, and had to.','D\'Amore-Hane',35308,2,0,'19','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(4,'Fadel Group','Carroll, Simonis and Lowe','He got behind Alice as he spoke, \'we were trying--\' \'I see!\' said the Mock Turtle. \'Seals, turtles, salmon, and so on.\' \'What a funny watch!\' she.','I vote the young man said, \'And your hair has become very white; And yet I wish you wouldn\'t mind,\' said Alice: \'three inches is such a long way back, and see how he can EVEN finish, if he would deny it too: but the Hatter replied. \'Of course it was,\' he said. (Which he certainly did NOT, being made entirely of cardboard.) \'All right, so far,\' said the King. \'Nothing whatever,\' said Alice. \'It goes on, you know,\' said Alice, a little wider. \'Come, it\'s pleased so far,\' thought Alice, \'to pretend to be two people! Why, there\'s hardly enough of me left to make the arches. The chief difficulty Alice found at first she thought of herself, \'I wonder what CAN have happened to you? Tell us all about it!\' and he poured a little bit of the house if it began ordering people about like mad things all this grand procession, came THE KING AND QUEEN OF HEARTS. Alice was very hot, she kept on puzzling about it while the Mock Turtle in the world! Oh, my dear paws! Oh my dear Dinah! I wonder what I.','Becker, Weissnat and Tillman',62149,5,1,'12','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(5,'Dach-Beatty','Cremin Group','Alice said; but was dreadfully puzzled by the hedge!\' then silence, and then at the flowers and those cool fountains, but she did it at all,\' said.','Mock Turtle: \'nine the next, and so on; then, when you\'ve cleared all the jurymen are back in a tone of great surprise. \'Of course it was,\' he said. \'Fifteenth,\' said the Rabbit\'s voice; and Alice looked round, eager to see it trying in a shrill, loud voice, and see what was on the floor: in another moment it was perfectly round, she came upon a little scream of laughter. \'Oh, hush!\' the Rabbit coming to look through into the air, I\'m afraid, sir\' said Alice, who had not attended to this last remark, \'it\'s a vegetable. It doesn\'t look like one, but the Dodo said, \'EVERYBODY has won, and all must have been was not an encouraging tone. Alice looked all round her once more, while the rest of the jurymen. \'It isn\'t mine,\' said the Gryphon. \'How the creatures argue. It\'s enough to drive one crazy!\' The Footman seemed to be sure; but I hadn\'t mentioned Dinah!\' she said to one of the garden, called out to sea. So they had been for some way, and nothing seems to suit them!\' \'I haven\'t the.','Heidenreich PLC',95275,2,1,'5','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(6,'Kuhic Group','Walsh LLC','The Dormouse slowly opened his eyes were getting so far off). \'Oh, my poor hands, how is it I can\'t quite follow it as to bring tears into her eyes.','WAS a narrow escape!\' said Alice, \'a great girl like you,\' (she might well say that \"I see what was the Cat went on, \'--likely to win, that it\'s hardly worth while finishing the game.\' The Queen turned crimson with fury, and, after glaring at her with large round eyes, and half believed herself in a frightened tone. \'The Queen will hear you! You see, she came upon a little glass table. \'Now, I\'ll manage better this time,\' she said, without even looking round. \'I\'ll fetch the executioner myself,\' said the Duck. \'Found IT,\' the Mouse was bristling all over, and both footmen, Alice noticed, had powdered hair that curled all over with diamonds, and walked two and two, as the question was evidently meant for her. \'Yes!\' shouted Alice. \'Come on, then!\' roared the Queen, \'and he shall tell you just now what the moral of that is--\"The more there is of yours.\"\' \'Oh, I beg your pardon!\' cried Alice in a low voice. \'Not at first, perhaps,\' said the Caterpillar. Here was another puzzling.','Rodriguez-Gerlach',75301,2,1,'3','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(7,'Lueilwitz-McDermott','Davis Ltd','I\'ve got to come out among the trees upon her knee, and the others all joined in chorus, \'Yes, please do!\' but the tops of the garden, and I never.','Dinah stop in the distance. \'And yet what a delightful thing a bit!\' said the Mock Turtle: \'crumbs would all come wrong, and she told her sister, as well wait, as she stood looking at the moment, \'My dear! I shall see it trot away quietly into the wood to listen. The Fish-Footman began by taking the little thing sobbed again (or grunted, it was only a pack of cards!\' At this moment Five, who had not attended to this last word with such a new idea to Alice, and she sat on, with closed eyes, and feebly stretching out one paw, trying to invent something!\' \'I--I\'m a little worried. \'Just about as she listened, or seemed to be a queer thing, to be no doubt that it had come back with the distant green leaves. As there seemed to have lessons to learn! Oh, I shouldn\'t want YOURS: I don\'t understand. Where did they live on?\' said Alice, very loudly and decidedly, and the cool fountains. CHAPTER VIII. The Queen\'s Croquet-Ground A large rose-tree stood near the door and went down to her feet in.','Davis, Stoltenberg and Funk',3082,5,1,'16','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(8,'Lowe, Gutmann and Effertz','Hirthe, Dickens and Romaguera','Mock Turtle. \'No, no! The adventures first,\' said the Mock Turtle said: \'advance twice, set to work at once without waiting for the hot day made her.','The Duchess took her choice, and was going on, as she spoke; \'either you or your head must be what he did it,) he did it,) he did it,) he did with the end of his Normans--\" How are you getting on?\' said Alice, who always took a great hurry; \'this paper has just been reading about; and when she had expected: before she found herself falling down a large flower-pot that stood near. The three soldiers wandered about for some time without interrupting it. \'They were learning to draw, you know--\' (pointing with his knuckles. It was the cat.) \'I hope they\'ll remember her saucer of milk at tea-time. Dinah my dear! I wish you would have this cat removed!\' The Queen smiled and passed on. \'Who ARE you talking to?\' said one of these cakes,\' she thought, \'and hand round the table, but it puzzled her a good deal on where you want to be?\' it asked. \'Oh, I\'m not used to it as to bring tears into her eyes; and once again the tiny hands were clasped upon her face. \'Very,\' said Alice: \'allow me to.','Mohr and Sons',82012,6,1,'14','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(9,'Rohan Group','Sauer, Mueller and Schmeler','Hatter grumbled: \'you shouldn\'t have put it in asking riddles that have no sort of lullaby to it in her hand, watching the setting sun, and thinking.','Alice: \'she\'s so extremely--\' Just then she remembered having seen in her brother\'s Latin Grammar, \'A mouse--of a mouse--to a mouse--a mouse--O mouse!\') The Mouse did not get hold of its voice. \'Back to land again, and the moon, and memory, and muchness--you know you say things are \"much of a good many voices all talking together: she made out the Fish-Footman was gone, and the moment she appeared; but she did not like to see it trying in a very melancholy voice. \'Repeat, \"YOU ARE OLD, FATHER WILLIAM,\' to the Mock Turtle in a sorrowful tone; \'at least there\'s no use in knocking,\' said the Cat, \'or you wouldn\'t keep appearing and vanishing so suddenly: you make one quite giddy.\' \'All right,\' said the last concert!\' on which the cook was leaning over the list, feeling very glad to find that she had plenty of time as she did not appear, and after a minute or two, they began solemnly dancing round and get in at the Caterpillar\'s making such VERY short remarks, and she could do, lying.','Herzog, Ritchie and Jakubowski',21612,6,1,'8','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(10,'Veum and Sons','Reichert-Zboncak','English,\' thought Alice; \'I daresay it\'s a French mouse, come over with William the Conqueror.\' (For, with all her fancy, that: he hasn\'t got no.','CHAPTER VI. Pig and Pepper For a minute or two, they began solemnly dancing round and look up in great disgust, and walked off; the Dormouse indignantly. However, he consented to go on crying in this way! Stop this moment, I tell you!\' said Alice. \'Nothing WHATEVER?\' persisted the King. \'Nothing whatever,\' said Alice. \'Of course they were\', said the Gryphon, half to herself, rather sharply; \'I advise you to set about it; if I\'m not the smallest notice of them attempted to explain it as far down the hall. After a minute or two sobs choked his voice. \'Same as if it makes rather a hard word, I will just explain to you to leave the court; but on the ground as she did not much larger than a pig, and she thought it over afterwards, it occurred to her chin upon Alice\'s shoulder, and it set to work shaking him and punching him in the kitchen that did not wish to offend the Dormouse crossed the court, she said to herself, for this time with one finger pressed upon its nose. The Dormouse again.','Gorczany LLC',65114,4,0,'5','2','2025-02-19 13:18:31','2025-02-19 13:18:31');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isVIP` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'lyda.klocko@example.net','$2y$12$I6kqoOjDawmaYOr.C1k3muvqDcPuAbnjKPEq/rr5TLMNgcHFyUh06','Domenico Lakin IV','Jerrold Stark','624 Jodie Rapid','New Mozelle','08653-2407','+12104579321','user','standard',0,'2025-02-19 13:18:31','qalPqGuYpk','2025-02-19 13:18:31','2025-02-19 13:18:31'),(2,'arlene95@example.com','$2y$12$I6kqoOjDawmaYOr.C1k3muvqDcPuAbnjKPEq/rr5TLMNgcHFyUh06','Payton Gutkowski','Hollie Romaguera I','134 Gloria Mills','Port Hilbertborough','37171-4651','+14194526005','employee','pro',1,'2025-02-19 13:18:31','3RoJzUqgBm','2025-02-19 13:18:31','2025-02-19 13:18:31'),(3,'christiana70@example.com','$2y$12$I6kqoOjDawmaYOr.C1k3muvqDcPuAbnjKPEq/rr5TLMNgcHFyUh06','Ronny Armstrong','Lester Bednar II','6376 Boyer Circle','Pietroport','51740','+15513423072','manager','standard',0,'2025-02-19 13:18:31','6dTb5I2gIR','2025-02-19 13:18:31','2025-02-19 13:18:31'),(4,'xprohaska@example.org','$2y$12$I6kqoOjDawmaYOr.C1k3muvqDcPuAbnjKPEq/rr5TLMNgcHFyUh06','Lowell Schoen MD','Lavina Hartmann','521 VonRueden Spring Apt. 175','Gusikowskimouth','85186-4077','+13212478618','master','pro',1,'2025-02-19 13:18:31','GET7Q2UWGF','2025-02-19 13:18:31','2025-02-19 13:18:31'),(5,'torrey89@example.net','$2y$12$I6kqoOjDawmaYOr.C1k3muvqDcPuAbnjKPEq/rr5TLMNgcHFyUh06','Haylee Hill','Miss Lottie Von DVM','23900 Dach Land','North Christy','96565','+16508181363','user','standard',0,'2025-02-19 13:18:31','Phlkw4KJgD','2025-02-19 13:18:31','2025-02-19 13:18:31'),(6,'conroy.noemie@example.org','$2y$12$I6kqoOjDawmaYOr.C1k3muvqDcPuAbnjKPEq/rr5TLMNgcHFyUh06','Dr. Ellsworth Turcotte','Mrs. Wendy Quigley II','17499 Luettgen Village','Marvinstad','19931','+14582706601','employee','pro',1,'2025-02-19 13:18:31','r8fu50msNy','2025-02-19 13:18:31','2025-02-19 13:18:31'),(7,'sydnie.huel@example.com','$2y$12$I6kqoOjDawmaYOr.C1k3muvqDcPuAbnjKPEq/rr5TLMNgcHFyUh06','Brain Zulauf','Manley Shields','6169 Dibbert Ridge Apt. 304','North Hannah','56171','+15404933322','manager','standard',0,'2025-02-19 13:18:31','fr53zI7D2l','2025-02-19 13:18:31','2025-02-19 13:18:31'),(8,'willie.okon@example.com','$2y$12$I6kqoOjDawmaYOr.C1k3muvqDcPuAbnjKPEq/rr5TLMNgcHFyUh06','Jennings Conn','Van Bosco I','7528 Fanny Key','Kertzmannfort','85268','+17546652678','master','pro',1,'2025-02-19 13:18:31','TuNnjcwCpP','2025-02-19 13:18:31','2025-02-19 13:18:31'),(9,'aweissnat@example.net','$2y$12$I6kqoOjDawmaYOr.C1k3muvqDcPuAbnjKPEq/rr5TLMNgcHFyUh06','Jules Morar','Skye Raynor','73435 Fern Garden','North Clinton','36693','+15014809170','user','standard',0,'2025-02-19 13:18:31','y1Poe0h1zr','2025-02-19 13:18:31','2025-02-19 13:18:31'),(10,'harry19@example.net','$2y$12$I6kqoOjDawmaYOr.C1k3muvqDcPuAbnjKPEq/rr5TLMNgcHFyUh06','Rita Fahey','Jermain Koch Jr.','27164 Luther Garden Suite 994','North Josianeland','25545','+19014218379','employee','pro',1,'2025-02-19 13:18:31','O3f6oKODxM','2025-02-19 13:18:31','2025-02-19 13:18:31'),(11,'jherzog@example.com','$2y$12$I6kqoOjDawmaYOr.C1k3muvqDcPuAbnjKPEq/rr5TLMNgcHFyUh06','Amelia Thompson IV','Caleb Hermiston','47824 Lilyan Burgs','North Boyd','22048','+15394899020','manager','standard',0,'2025-02-19 13:18:31','EDedFOMgFX','2025-02-19 13:18:31','2025-02-19 13:18:31'),(12,'kutch.bernie@example.net','$2y$12$I6kqoOjDawmaYOr.C1k3muvqDcPuAbnjKPEq/rr5TLMNgcHFyUh06','Tillman Heller','Polly Weber','13401 Eriberto Turnpike Suite 854','Jacobschester','61012','+16783392995','master','pro',1,'2025-02-19 13:18:31','qaKTuggsjv','2025-02-19 13:18:31','2025-02-19 13:18:31'),(13,'rebekah96@example.org','$2y$12$I6kqoOjDawmaYOr.C1k3muvqDcPuAbnjKPEq/rr5TLMNgcHFyUh06','David Gibson','Dr. Sven Bednar','6860 Kemmer Courts','Schusterview','22575-9794','+15397820504','user','standard',0,'2025-02-19 13:18:31','lUmQMG4RiJ','2025-02-19 13:18:31','2025-02-19 13:18:31'),(14,'keven23@example.org','$2y$12$I6kqoOjDawmaYOr.C1k3muvqDcPuAbnjKPEq/rr5TLMNgcHFyUh06','Natasha Wiza','Lola Mann MD','5362 Kris Locks Suite 901','Reillymouth','78766-8432','+19497891870','employee','pro',1,'2025-02-19 13:18:31','VRafA9zBmy','2025-02-19 13:18:31','2025-02-19 13:18:31'),(15,'twalker@example.net','$2y$12$I6kqoOjDawmaYOr.C1k3muvqDcPuAbnjKPEq/rr5TLMNgcHFyUh06','Prof. Uriah Frami V','Kyla Adams','6014 Grady Island','New Raven','79351-7149','+12838330531','manager','standard',0,'2025-02-19 13:18:31','4tlUNtXMxp','2025-02-19 13:18:31','2025-02-19 13:18:31'),(16,'userl@exalmple.com','$2y$12$/PLi5MUyX7G2WPlkBqLXwu5eqVhgr04ReIMG3PV6uNfrFRE5vFRp2','string','string','string','string','string','string','string','string',1,NULL,NULL,'2025-02-19 14:21:02','2025-02-19 14:21:02'),(17,'admin@admin.com','$2y$12$PIl6l6bN8xwZEpkPoPklw.8zTpb8o3rB0nBCelZ.MSLaqw9WvvF2S','string','string','string','string','string','string','string','string',1,NULL,NULL,'2025-02-19 14:21:59','2025-02-19 14:21:59');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-20 11:08:01
