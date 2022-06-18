<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use PDO;
use Session;
use statement;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;
use Mail;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Input;

class instaltionController extends Controller
{

    public function index(Request $request)
	{
		$this->validate($request, [

		 'password'=>'min:6|max:12|regex:/(^[A-Za-z0-9]+$)+/',
		 'confirm' => 'same:password',
	      ]);

		if(file_exists( 'installed.txt' ))
		{
				return view('\auth.login');
		}
		else
		{
			$file = '.env';
			$content = file_get_contents($file);
			$host=Input::get('db_host');
			$d_user_name=Input::get('db_username');
			$db_password=Input::get('db_pass');
			$databasename=Input::get('db_name');

			$conn = new PDO("mysql:host=$host;port=3306", "$d_user_name", "$db_password");
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$con = mysqli_connect($host,$d_user_name,$db_password);
			// $sql="DROP DATABASE $databasename";
			// $data=$conn->exec($sql);

			if (!$con) {
			  die('Not connected : ' . mysqli_error());
			}

			// make foo the current db
			$db_selected = mysqli_select_db($con, $databasename);
			if (!$db_selected)
			{
				$sql="TRUNCATE DATABASE $databasename";
			    $data=$conn->exec($sql);
			}



			$con = mysqli_connect($host,$d_user_name,$db_password,$databasename);
			if (mysqli_connect_errno())
			{
				echo "Failed to connect to Database : " . mysqli_connect_error();
				die;
			}

			$content = str_replace(["CUST_HOST","CUST_USERNAME","CUST_PW","CUST_DB_NAME"],[$host,$d_user_name,$db_password,$databasename],$content);
			$status = file_put_contents($file, $content);
			$systemname=Input::get('name');
			$s_email=Input::get('email');
			$address=Input::get('address');
			$f_name=Input::get('firstname');
			$l_name=Input::get('lastname');
			$email=Input::get('loginemail');
			$password=bcrypt(Input::get('password'));
			$c_password=Input::get('confirm');
			$this->garageTableInstall($databasename,$d_user_name,$host,$db_password,$f_name,$l_name,$address,$email,$password,$systemname,$con,$s_email);
		}
		 Session::put('firsttime','Your Installation is Successful');
		 return redirect('/');

	}

	private function garageTableInstall($databasename,$d_user_name,$host,$db_password,$f_name,$l_name,$address,$email,$password,$systemname,$con,$s_email)
    {

		$conn = new PDO("mysql:host=$host;dbname=$databasename;port=3306", "$d_user_name", "$db_password");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		/* $sql="DROP DATABASE $databasename";
		$data=$conn->exec($sql);

		$sql1="CREATE DATABASE $databasename";
		$data=$conn->exec($sql1); */

		$conn = new PDO("mysql:host=$host;dbname=$databasename;port=3306", "$d_user_name", "$db_password");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//admins table
		$sql="CREATE TABLE IF NOT EXISTS `admins` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `created_at` timestamp NULL DEFAULT NULL,
			  `updated_at` timestamp NULL DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `admins_email_unique` (`email`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5";
		$data=$conn->exec($sql);
		//migrations table
		$sql="CREATE TABLE IF NOT EXISTS `migrations` (
			  `migration` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
			  `batch` int(11) DEFAULT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
		 $data=$conn->exec($sql);
		//password_resets
		$sql="CREATE TABLE IF NOT EXISTS `password_resets` (
		  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `created_at` timestamp DEFAULT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  KEY `password_resets_email_index` (`email`),
		  KEY `password_resets_token_index` (`token`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
		$data=$conn->exec($sql);
		//tbl_accessrights
		$sql="CREATE TABLE IF NOT EXISTS `tbl_accessrights` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `menu_name` varchar(255) DEFAULT NULL,
		  `customers` int(11) DEFAULT NULL,
		  `employee` int(11) DEFAULT NULL,
		  `support_staff` int(11) DEFAULT NULL,
		  `accountant` int(11) DEFAULT NULL,
		  `created_at` timestamp NULL DEFAULT NULL,
		  `updated_at` timestamp NULL DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23";
		$data=$conn->exec($sql);
		$insert ="INSERT INTO `tbl_accessrights` (`id`, `menu_name`, `customers`, `employee`, `support_staff`, `accountant`, `created_at`, `updated_at`) VALUES
		(1, 'Settings', 1, 1, 1, 1, '2022-08-07 23:39:13', NULL),
		(2, 'Inventory', 0, 1, 1, 1, '2022-11-29 05:26:09', '2017-11-29 05:26:09'),
		(3, 'Customers', 1, 1, 1, 1, '2022-11-29 05:27:46', '2017-11-29 05:27:46'),
		(4, 'Employees', 1, 1, 1, 1, '2022-11-29 05:32:55', '2017-11-29 05:32:55'),
		(5, 'Support Staffs', 1, 1, 1, 1, '2022-11-29 05:32:55', '2017-11-29 05:32:55'),
		(6, 'Accountants', 1, 1, 1, 1, '2021-11-29 05:33:42', '2017-11-29 05:33:42'),
		(7, 'Vehicles', 1, 1, 1, 1, '2022-01-29 05:33:42', '2017-11-29 05:33:42'),
		(8, 'Services', 1, 1, 1, 1, '2022-01-29 05:34:36', '2017-11-29 05:34:36'),
		(9, 'Invoices', 1, 1, 1, 1, '2022-01-29 05:34:36', '2017-11-29 05:34:36'),
		(10, 'Job Card', 1, 1, 1, 1, '2017-11-29 05:35:25', '2017-11-29 05:35:25'),
		(11, 'Accounts & Tax Rates', 0, 0, 1, 1, '2017-11-29 05:35:25', '2017-11-29 05:35:25'),
		(12, 'Sales', 1, 1, 1, 1, '2022-11-30 01:13:30', '2017-11-30 01:13:30'),
		(13, 'Compliance', 0, 0, 1, 1, '2022-11-30 01:13:30', '2017-11-30 01:13:30'),
		(14, 'Reports', 0, 0, 1, 1, '2022-11-30 01:38:27', '2017-11-30 01:38:27'),
		(15, 'Email Templates', 0, 0, 1, 1, '2022-11-30 05:28:23', '2017-11-30 05:28:23'),
		(18, 'Custom Fields', 0, 0, 1, 1, '2022-11-30 06:34:13', '2017-11-30 06:34:13'),
		(19, 'Observation library', 0, 0, 1, 1, '2017-11-30 06:34:13', '2017-11-30 06:34:13'),
		(20, 'Sales Part', 0, 1, 1, 1, '2017-11-30 01:13:30', '2017-11-30 01:13:30')";
		$data=$conn->exec($insert);

		//tbl_account_tax_rates
		$sql="CREATE TABLE IF NOT EXISTS `tbl_account_tax_rates` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `taxname` varchar(255) DEFAULT NULL,
		  `tax` varchar(255) DEFAULT NULL,
		  `created_at` timestamp NULL DEFAULT NULL,
		  `updated_at` timestamp NULL DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
		$data=$conn->exec($sql);
		//tbl_business_hours
		$sql="CREATE TABLE IF NOT EXISTS `tbl_business_hours` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `day` int(11) DEFAULT NULL,
		  `from` int(11) DEFAULT NULL,
		  `to` int(11) DEFAULT NULL,
		  `created_at` timestamp NULL DEFAULT NULL,
		  `updated_at` timestamp NULL DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
		$data=$conn->exec($sql);
		$sql ="INSERT INTO `tbl_business_hours` (`id`, `day`, `from`, `to`, `created_at`, `updated_at`) VALUES
		(1, 1, 9, 17, '2018-08-01 01:28:47', '2018-08-07 07:34:29'),
		(2, 2, 9, 18, '2018-08-01 01:29:05', '2018-08-01 01:29:05'),
		(8, 6, 0, 0, '2018-08-01 01:48:20', '2018-08-07 07:34:38')";
		$data=$conn->exec($sql);
		//tbl_checkout_categories
		$sql="CREATE TABLE IF NOT EXISTS `tbl_checkout_categories` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `vehicle_id` int(11) DEFAULT NULL,
		  `checkout_point` varchar(255) DEFAULT NULL,
		  `create_by` int(11) DEFAULT NULL,
		  `created_at` timestamp NULL DEFAULT NULL,
		  `updated_at` timestamp NULL DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
		$data=$conn->exec($sql);

		//sale_part
		$sql="CREATE TABLE IF NOT EXISTS `tbl_sale_parts` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `bill_no` varchar(255) DEFAULT NULL,
		  `quantity` int(11) DEFAULT NULL,
		  `salesmanname` varchar(255) DEFAULT NULL,
		  `date` varchar(255) DEFAULT NULL,
		  `product_id` int(11) DEFAULT NULL,
		  `total_price` decimal(10,2) DEFAULT NULL,
		  `price` decimal(10,2) DEFAULT NULL,
		  `customer_id` int(11) DEFAULT NULL,
		  `created_at` timestamp NULL DEFAULT NULL,
		  `updated_at` timestamp NULL DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
		$data=$conn->exec($sql);

		$sql="CREATE TABLE IF NOT EXISTS `tbl_checkout_results` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `point_id` int(11) DEFAULT NULL,
		  `service_id` int(11) DEFAULT NULL,
		  `changepoint` varchar(255) DEFAULT NULL,
		  `comment` varchar(255) DEFAULT NULL,
		  `comment_by` int(11) DEFAULT NULL,
		  `created_at` timestamp NULL DEFAULT NULL,
		  `updated_at` timestamp NULL DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ";
		$data=$conn->exec($sql);

		$sql="CREATE TABLE IF NOT EXISTS `tbl_cities` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) DEFAULT NULL,
		  `state_id` int(11) DEFAULT NULL,
		  `created_at` timestamp NULL DEFAULT NULL,
		  `updated_at` timestamp NULL DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48315";
		$data=$conn->exec($sql);

$sql = "INSERT INTO `tbl_cities` (`id`, `name`, `state_id`) VALUES
(41298, 'Kramators''k', 3771),
(41299, 'Krasnoarmiys''k', 3771),
(41300, 'Makiyivka', 3771),
(41301, 'Mariupol''', 3771),
(41302, 'Shakhtars''k', 3771),
(41303, 'Slov''yans''k', 3771),
(41304, 'Snizhne', 3771),
(41305, 'Torez', 3771),
(41306, 'Yenakiyeve', 3771),
(41307, 'Ivano-Frankivs''k', 3772),
(41308, 'Kalush', 3772),
(41309, 'Kolomyya', 3772),
(41310, 'Izyum', 3773),
(41311, 'Kharkiv', 3773),
(41312, 'Lozova', 3773),
(41313, 'Volchansk', 3774),
(41314, 'Kherson', 3775),
(41315, 'Nova Kakhovka', 3775),
(41316, 'Geologov', 3776),
(41317, 'Kam''yanets''-Podil''s''kyy', 3776),
(41318, 'Khmel''nyts''kyy', 3776),
(41319, 'Shepetivka', 3776),
(41320, 'khmelnitskiy', 3776),
(41321, 'Kirovohrad', 3777),
(41322, 'Oleksandriya', 3777),
(41323, 'Svidlovodsk', 3777),
(41324, 'Dzhankoy', 3778),
(41325, 'Feodosiya', 3778),
(41326, 'Kerch', 3778),
(41327, 'Simferopol''', 3778),
(41328, 'Yalta', 3778),
(41329, 'Yevpatoriya', 3778),
(41330, 'Kiev', 3779),
(41331, 'Kyyiv', 3779),
(41332, 'Bila Tserkva', 3780),
(41333, 'Boryspil''', 3780),
(41334, 'Brovary', 3780),
(41335, 'Fastiv', 3780),
(41336, 'Chervonohrad', 3781),
(41337, 'Drohobych', 3781),
(41338, 'L''viv', 3781),
(41339, 'Stryy', 3781),
(41340, 'Yavoriv', 3781),
(41341, 'Alchevs''k', 3782),
(41342, 'Antratsyt', 3782),
(41343, 'Bryanka', 3782),
(41344, 'Krasnodon', 3782),
(41345, 'Krasnyy Luch', 3782),
(41346, 'Luhans''k', 3782),
(41347, 'Luhansk', 3782),
(41348, 'Lysychans''k', 3782),
(41349, 'Pervomays''k', 3782),
(41350, 'Roven''ky', 3782),
(41351, 'Rubizhne', 3782),
(41352, 'Stakhanov', 3782),
(41353, 'Sverdlovs''k', 3782),
(41354, 'Syeverodonets''k', 3782),
(41355, 'Mykolayiv', 3783),
(41356, 'Pervomays''k', 3783),
(41357, 'Bilhorod-Dnistrovs''kyy', 3784),
(41358, 'Illichivs''k', 3784),
(41359, 'Izmayil', 3784),
(41360, 'Odesa', 3784),
(41361, 'Odessa', 3785),
(41362, 'Komsomol''s''k', 3786),
(41363, 'Kremenchuh', 3786),
(41364, 'Lubny', 3786),
(41365, 'Poltava', 3786),
(41366, 'Rivne', 3787),
(41367, 'Konotop', 3789),
(41368, 'Okhtyrka', 3789),
(41369, 'Romny', 3789),
(41370, 'Shostka', 3789),
(41371, 'Sumy', 3789),
(41372, 'Ternopil''', 3790),
(41373, 'Kovel''', 3791),
(41374, 'Luts''k', 3791),
(41375, 'Novovolyns''k', 3791),
(41376, 'Vinnitsa', 3792),
(41377, 'Vinnytsya', 3792),
(41378, 'Mukacheve', 3793),
(41379, 'Uzhhorod', 3793),
(41380, 'Berdyans''k', 3794),
(41381, 'Enerhodar', 3794),
(41382, 'Melitpol''', 3794),
(41383, 'Zaporizhia', 3794),
(41384, 'Berdychiv', 3795),
(41385, 'Korosten''', 3795),
(41386, 'Novohrad-Volyns''kyy', 3795),
(41387, 'Zhytomyr', 3795),
(41388, 'Ajman', 3797),
(41389, 'Al Qusais', 3798),
(41390, 'Deira', 3798),
(41391, 'Dubai', 3798),
(41392, 'Jebel Ali', 3798),
(41393, 'Sharjah', 3800),
(41394, 'Khawr Fakkan', 3803),
(41395, 'al-Fujayrah', 3803),
(41396, 'Cleveland', 3805),
(41397, 'Gilberdyke', 3805),
(41398, 'Llanrwst', 3805),
(41399, 'Swadlincote', 3805),
(41400, 'Turriff', 3805),
(41401, 'Westhill', 3806),
(41402, 'Oban', 3807),
(41403, 'Craigavon', 3808),
(41404, 'Barton-le-Clay', 3809),
(41405, 'Bedford', 3809),
(41406, 'Biggleswade', 3809),
(41407, 'Caddington', 3809),
(41408, 'Flitton', 3809),
(41409, 'Flitwick', 3809),
(41410, 'Leighton Buzzard', 3809),
(41411, 'Marston Moretaine', 3809),
(41412, 'Sandy', 3809),
(41413, 'Westoning', 3809),
(41414, 'Dundonald', 3810),
(41415, 'Holywood', 3810),
(41416, 'Berkshire', 3811),
(41417, 'Bracknell', 3811),
(41418, 'Littlewick Green', 3811),
(41419, 'Maidenhead', 3811),
(41420, 'Newbury', 3811),
(41421, 'Reading', 3811),
(41422, 'Sandhurst', 3811),
(41423, 'Slough', 3811),
(41424, 'Sunninghill', 3811),
(41425, 'Twyford', 3811),
(41426, 'Windsor', 3811),
(41427, 'Wokingham', 3811),
(41428, 'Woodley', 3811),
(41429, 'Coleshill', 3812),
(41430, 'Edgbaston', 3812),
(41431, 'Hockley', 3812),
(41432, 'Ladywood', 3812),
(41433, 'Nechells', 3812),
(41434, 'Rubery', 3812),
(41435, 'Small Heath', 3812),
(41436, 'Angus', 3813),
(41437, 'Bridgnorth', 3814),
(41438, 'Avon', 3815),
(41439, 'Fishponds', 3815),
(41440, 'Henleaze', 3815),
(41441, 'Thornbury', 3815),
(41442, 'Warmley', 3815),
(41443, 'Amersham', 3816),
(41444, 'Aston Clinton', 3816),
(41445, 'Beaconsfield', 3816),
(41446, 'Bletchley', 3816),
(41447, 'Bourne End', 3816),
(41448, 'Buckingham', 3816),
(41449, 'High Wycombe', 3816),
(41450, 'Iver', 3816),
(41451, 'Marlow', 3816),
(41452, 'Milton Keynes', 3816),
(41453, 'Newport Pagnell', 3816),
(41454, 'Piddington', 3816),
(41455, 'Princes Risborough', 3816),
(41456, 'Rowsham', 3816),
(41457, 'Cambridge', 3817),
(41458, 'Ely', 3817)";
$data=$conn->exec($sql);
//tbl_colors
$sql="CREATE TABLE IF NOT EXISTS `tbl_colors` (
	 `id` int(11) NOT NULL AUTO_INCREMENT,
	 `color` varchar(255) DEFAULT NULL,
	 `created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_countries
$sql="CREATE TABLE IF NOT EXISTS `tbl_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sortname` varchar(3) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `phonecode` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=247";
$data=$conn->exec($sql);

$sql ="INSERT INTO `tbl_countries` (`id`, `sortname`, `name`, `phonecode`) VALUES
(229, 'AE', 'United Arab Emirates', 971),
(230, 'GB', 'United Kingdom', 44),
(231, 'US', 'United States', 1),
(232, 'UM', 'United States Minor Outlying Islands', 1),
(233, 'IN', 'India', 598),
(246, 'ZW', 'Zimbabwe', 263)";
$data=$conn->exec($sql);
//tbl_currency_records
$sql="CREATE TABLE IF NOT EXISTS `tbl_currency_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(100) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `code` varchar(25) DEFAULT NULL,
  `symbol` varchar(25) DEFAULT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132";
$data=$conn->exec($sql);

$sql ="INSERT INTO `tbl_currency_records` (`id`, `country`, `currency`, `code`, `symbol`, `timezone`) VALUES
(1, 'Albania', 'Leke', 'ALL', 'Lek', 'Europe/Tirane'),
(2, 'Dubai', 'Dirham', 'AED', 'AED', 'Areab/Regina'),
(3, 'India', 'Rupees', 'INR', 'Rp', 'Asia/Kolkata'),
(4, 'Zimbabwe', 'Zimbabwe Dollars', 'ZWD', 'Z', 'Africa/Harare')";
$data=$conn->exec($sql);

// table currencies

$sql="CREATE TABLE `currencies` (
  `id` int(11) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `code` varchar(25) DEFAULT NULL,
  `symbol` varchar(25) DEFAULT NULL,
  `thousand_separator` varchar(10) DEFAULT NULL,
  `decimal_separator` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=132";
$data=$conn->exec($sql);

$sql ="INSERT INTO `currencies` (`id`, `country`, `currency`, `code`, `symbol`, `thousand_separator`, `decimal_separator`) VALUES
(1, 'Dubai', 'AED', 'AED', 'AED', ',', '.'),
(2, 'America', 'Dollars', 'USD', '$', ',', '.'),
(50, 'Hong Kong', 'Dollars', 'HKD', '$', ',', '.'),
(51, 'Hungary', 'Forint', 'HUF', 'Ft', ',', '.'),
(52, 'Iceland', 'Kronur', 'ISK', 'kr', ',', '.'),
(53, 'India', 'Rupees', 'INR', 'Rp', ',', '.'),
(131, 'Zimbabwe', 'Zimbabwe Dollars', 'ZWD', 'Z$', ',', '.')";
$data=$conn->exec($sql);
//tbl_custom_fields
$sql="CREATE TABLE IF NOT EXISTS `tbl_custom_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `required` varchar(255) DEFAULT NULL,
  `always_visable` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_expenses
$sql="CREATE TABLE IF NOT EXISTS `tbl_expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main_label` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_expenses_history_records
$sql="CREATE TABLE IF NOT EXISTS `tbl_expenses_history_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tbl_expenses_id` int(11) DEFAULT NULL,
  `expense_amount` varchar(255) DEFAULT NULL,
  `label_expense` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_fuel_types
$sql="CREATE TABLE IF NOT EXISTS `tbl_fuel_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fuel_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_gatepasses
$sql="CREATE TABLE IF NOT EXISTS `tbl_gatepasses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gatepass_no` varchar(11) DEFAULT NULL,
  `jobcard_id` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `ser_pro_status` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `gatepass_create_date` datetime DEFAULT NULL,
  `service_out_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33";
$data=$conn->exec($sql);
//tbl_holidays
$sql="CREATE TABLE IF NOT EXISTS `tbl_holidays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_incomes
$sql="CREATE TABLE IF NOT EXISTS `tbl_incomes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_number` int(15) DEFAULT NULL,
  `payment_number` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '{ 0 - Unpaid . 1-Half Paid , 2-Full Paid }',
  `payment_type` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `main_label` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_income_history_records
$sql="CREATE TABLE IF NOT EXISTS `tbl_income_history_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tbl_income_id` int(11) DEFAULT NULL,
  `income_amount` double(15,2) DEFAULT NULL,
  `income_label` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_invoices
$sql="CREATE TABLE IF NOT EXISTS `tbl_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_number` int(15) DEFAULT NULL,
  `payment_number` varchar(20) DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `job_card` varchar(50) DEFAULT NULL,
  `payment_type` varchar(20) DEFAULT NULL,
  `payment_status` int(10) DEFAULT '0' COMMENT '{ 0 - Unpaid . 1-Half Paid , 2-Full Paid }',
  `total_amount` double(15,2) DEFAULT NULL,
  `grand_total` double(15,2) DEFAULT NULL,
  `discount` double(15,2) DEFAULT NULL,
  `paid_amount` double(15,2) DEFAULT NULL,
  `amount_recevied` double(15,2) DEFAULT NULL,
  `tax_name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `details` varchar(50) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '0=Service, 1=Sales,2=salepart',
  `charge_id` varchar(255) DEFAULT NULL,
  `sales_service_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//$tbl_payments
$sql="CREATE TABLE IF NOT EXISTS `tbl_payment_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoices_id` int(11) DEFAULT NULL,
  `amount` double(15,2) DEFAULT NULL,
  `payment_type` varchar(20) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_number` varchar(20) DEFAULT NULL,
  `note` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_jobcard_details
$sql="CREATE TABLE IF NOT EXISTS `tbl_jobcard_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) DEFAULT NULL,
  `jocard_no` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `in_date` datetime DEFAULT NULL,
  `out_date` datetime DEFAULT NULL,
  `delay_date` datetime DEFAULT NULL,
  `kms_run` varchar(30) DEFAULT NULL,
  `done_status` int(1) DEFAULT NULL,
  `coupan_no` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_sug` text DEFAULT NULL,
  `customer_comp` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_language_directions
$sql="CREATE TABLE IF NOT EXISTS `tbl_language_directions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `direction` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2";
$data=$conn->exec($sql);
$sql ="INSERT INTO `tbl_language_directions` (`id`, `direction`, `created_at`, `updated_at`) VALUES
(1, 'ltr', '2018-04-16 10:52:51', '2018-04-16 10:52:51')";
$data=$conn->exec($sql);

//`updatekey`
$sql="CREATE TABLE `updatekey` (
  `id` int(11) NOT NULL,
  `stripe_id` int(11) DEFAULT NULL,
  `secret_key` varchar(255) DEFAULT NULL,
  `publish_key` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2;";
$data=$conn->exec($sql);

$sql="INSERT INTO `updatekey` (`id`, `stripe_id`, `secret_key`, `publish_key`, `created_at`, `updated_at`) VALUES
(1, 9, 'sk_test_Cm3dIuyredSIdYArKGp9INBU', 'pk_test_8xNuwYhDeaKJIGgIJ9OmCHa0', '2018-08-17 09:27:26', '2018-08-17 09:30:26')";
$data=$conn->exec($sql);

//tbl_mail_notifications
$sql="CREATE TABLE IF NOT EXISTS `tbl_mail_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notification_label` varchar(255) DEFAULT NULL,
  `notification_for` varchar(255) DEFAULT NULL,
  `notification_text` text DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `send_from` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `is_send` int(10) DEFAULT NULL DEFAULT '0' COMMENT '0=enable,1=disable',
  `description_of_mailformate` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13";
$data=$conn->exec($sql);

$sql ="INSERT INTO `tbl_mail_notifications` (`id`, `notification_label`, `notification_for`, `notification_text`, `subject`, `send_from`, `status`,  `is_send`,`description_of_mailformate`, `created_at`, `updated_at`) VALUES
(1, 'Email notification for users registration', 'User_registration', 'Dear { user_name },\r\n\r\n          You are successfully registered at { system_name }. Your username: { email } and password: { Password }. \r\nsystem link { system_link }\r\n\r\nRegards From { system_name }.', 'Welcome to { system_name }', 'yatin.patel@dasinfomedia.com',0, 0, '{ system_name } = System Name <br/> \n{ user_name } = Add user Name<br/> \n{ email } = user Email Address<br/>\n{ Password } = user Password \n ', '2018-01-08 03:51:21', '2018-04-05 20:26:51'),
(2, 'Sales invoice mail notification', 'Sales_notification', 'Dear { Customer_name },\r\n\r\n         Thank You for your recent business with us. Please Find attached a detailed copy of the invoice for your Perusal. \r\n\r\nThe total amount due is { amount } to be salesed by { date }.\r\n\r\n{ invoice }\r\n\r\nRegards From  { system_name }.', 'Thanks for your recent business with  { system_name } Invoice { invoice_ID } is due for the same.', 'yatin.patel@dasinfomedia.com', 0,0, '{ Customer_name } = Customer name <br/> { amount } = Total amount of sales <br/> { date } = sales date <br/> { invoice } = Invoice print <br/>  { system_name } = System Name ', '2018-01-10 00:34:10', '2018-01-10 18:21:58'),
(3, 'Generating free service coupons', 'free_service_coupons', 'Dear { Customer_name },\r\n\r\nYou are entitled for Free service for your recent purchase of { manufacturer } { model_Number }.\r\n Here are the couponst:{ coupon_list }\r\n\r\n\r\nRegards From { system_name }.', 'You are entitled to Free service for your recent purchase of { manufacturer } { model_Number }', 'yatin.patel@dasinfomedia.com', 0,0, '{ Customer_name } = Customer name </br>\n{ manufacturer } = Vehicle brand name </br>\n{ model_Number } = Vehicle name </br>\n{ coupon_list } = Coupon number </br>\n{ system_name } = System name', '2018-01-10 04:08:27', '2018-01-10 18:25:30'),
(4, 'On successful job card creation', 'successful_jobcard', 'Dear { Customer_name },\r\n\r\n         Thank you for bringing your vehicle to our service center.Your Jobcard Number is { jobcard_number } on { service_date }  for { detail }\r\n     \r\nRegards From { system_name }. ', 'Your recent Vehicle service request is successful and jobcard { jobcard_number } is created for you.', 'yatin.patel@dasinfomedia.com',0, 0, '{ customer_name } = Customer name </br>\n{ jobcard_number } = Jobcard number </br>\n{ service_date } = Service date </br>\n{ detail } = Service details </br>\n{ system_name } = System name \n', '2018-01-10 04:26:37', '2018-01-11 18:09:02'),
(5, 'Service done status Invoice notification of customer', 'done_service_invoice', 'Dear { Customer_name },\r\n\r\n         Your services { service_title }  has been completed on { service_date }.\r\n     The total amount due is { total_amount }.\r\n   { Invoice }\r\nRegards From { system_name }. ', 'Your recent Vehicle service request is successful and jobcard { jobcard_no } is created for you.', 'yatin.patel@dasinfomedia.com',0, 0, '{ customer_name } = Customer name </br>\r\n{ service_title } = Service title </br>\r\n{ service_date } = Service date </br>\r\n{ total_amount } = Total amount sales </br>\r\n{ Invoice } = Invoice service </br>\r\n{ system_name } = system name </br>\r\n{ jobcard_number } = Service jobcard number ', '2018-01-10 04:18:25', '2018-01-10 23:07:35'),
(6, 'Service Due notification  before next week, next month,  admin,customer, employee', 'Service Due', 'Dear { user_name },\r\n\r\n          Your Pre approved free services is Coming up on  { month } - { year } This is Just a Reminder mail.\r\n    \r\n{ service_list }\r\n     \r\nRegards From { system_name }. ', '   Next { month_week } service Due on summery for { system name  }  for   { month } - { year } .', 'yatin.patel@dasinfomedia.com',0, 0, '{ user_name } = User name </br>\n{ service_date } = Service date </br>\n{ service_list } = Service List </br>\n{ system_name } = System name \n', NULL, '2018-09-15 04:33:34'),
(8, 'Monthly service list notification to admin', 'Monthly_service_notification', 'Dear { admin },\r\n\r\n         Monthly Services list attached.\r\n\r\n\r\n { service_list }\r\n\r\n\r\nRegards From ,{ system_name }.', 'Monthly service completion summary for { system_name } for { month } - { year }', 'yatin.patel@dasinfomedia.com', 0,0, '{ admin } = admin name </br>\r\n{ service_list } = Service List Month </br>\r\n{ system_name } = System name', '2018-01-10 03:47:58', '2018-02-20 18:24:33'),
(9, 'Weekly services list notification to employee', 'weekly_servicelist', 'Dear { employee },\r\n\r\n         Weekly Services list attached.\r\n\r\n\r\n { service_list }\r\n\r\n\r\nRegards From ,\r\n{ system_name }.', 'Weekly service completetion summry for { system_name } for { month } { year }', 'yatin.patel@dasinfomedia.com', 0,0, '{ employee } = Employee name </br>\r\n{ service_list } = Weekly service list </br>\r\n{ system_name } = system name', '2018-01-10 03:59:55', '2018-01-10 18:25:13')";
$data=$conn->exec($sql);
//tbl_model_names
$sql="CREATE TABLE IF NOT EXISTS `tbl_model_names` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
 //Table structure for table `tbl_observation_points`
$sql="CREATE TABLE IF NOT EXISTS `tbl_observation_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `observation_type_id` int(11) DEFAULT NULL,
  `observation_point` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_observation_types
$sql="CREATE TABLE IF NOT EXISTS `tbl_observation_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_payments
$sql="CREATE TABLE IF NOT EXISTS `tbl_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_points
$sql="CREATE TABLE IF NOT EXISTS `tbl_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checkout_subpoints` varchar(255) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `checkout_point` varchar(255) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_products
$sql="CREATE TABLE `tbl_products` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`product_no` varchar(255) DEFAULT NULL,
	`product_date` date DEFAULT NULL,
	`product_image` varchar(255) DEFAULT NULL,
	`code` varchar(255) DEFAULT NULL,
	`name` varchar(255) DEFAULT NULL,
	`product_type_id` int(11) DEFAULT NULL,
	`color_id` int(11) DEFAULT NULL,
	`price` varchar(255) DEFAULT NULL,
	`supplier_id` int(11) DEFAULT NULL,
	`warranty` varchar(255) DEFAULT NULL,
	`quantity` varchar(255) DEFAULT NULL,
	`category` int(10) DEFAULT NULL,
	`unit` int(11) DEFAULT NULL,
	`created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
$data=$conn->exec($sql);
//tbl_product_types
$sql="CREATE TABLE IF NOT EXISTS `tbl_product_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_product_units
$sql="CREATE TABLE IF NOT EXISTS `tbl_product_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_purchases
$sql="CREATE TABLE IF NOT EXISTS `tbl_purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_purchase_history_records
$sql="CREATE TABLE IF NOT EXISTS `tbl_purchase_history_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `category` int(10) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `total_amount` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_purchase_histores_ibfk_1` (`purchase_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_rto_taxes
$sql="CREATE TABLE IF NOT EXISTS `tbl_rto_taxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) DEFAULT NULL,
  `registration_tax` varchar(255) DEFAULT NULL,
  `number_plate_charge` varchar(255) DEFAULT NULL,
  `muncipal_road_tax` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_sales
$sql="CREATE TABLE IF NOT EXISTS `tbl_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `bill_no` varchar(255) DEFAULT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `vehicle_brand` int(11) DEFAULT NULL,
  `chassisno` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `registration_no` varchar(100) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `total_price` varchar(255) DEFAULT NULL,
  `no_of_services` int(11) DEFAULT NULL,
  `interval` varchar(255) DEFAULT NULL,
  `date_gap` varchar(255) DEFAULT NULL,
  `salesmanname` varchar(255) DEFAULT NULL,
  `assigne_to` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_sales_taxes
$sql="CREATE TABLE IF NOT EXISTS `tbl_sales_taxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tr_id` int(11) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `tax_name` varchar(255) DEFAULT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_services
$sql="CREATE TABLE IF NOT EXISTS `tbl_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_no` varchar(255) DEFAULT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `service_date` datetime DEFAULT NULL,
  `full_date` varchar(255) DEFAULT NULL,
  `title` varchar(255) NULL DEFAULT NULL,
  `assign_to` int(11) DEFAULT NULL,
  `service_category` varchar(30) DEFAULT NULL,
  `done_status` varchar(255) DEFAULT NULL,
  `charge` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `employee_status` int(11) DEFAULT NULL,
  `is_appove` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_service_observation_points
$sql="CREATE TABLE IF NOT EXISTS `tbl_service_observation_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `services_id` int(11) DEFAULT NULL,
  `observation_points_id` int(11) DEFAULT NULL,
  `review` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ";
$data=$conn->exec($sql);
//tbl_service_pros
$sql="CREATE TABLE IF NOT EXISTS `tbl_service_pros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) DEFAULT NULL,
  `tbl_service_observation_points_id` int(11) DEFAULT NULL,
  `category_comments` text,
  `product_id` int(11) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `total_price` varchar(255) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `obs_point` varchar(255) DEFAULT NULL,
  `chargeable` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
 `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_service_taxes
$sql="CREATE TABLE IF NOT EXISTS `tbl_service_taxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) DEFAULT NULL,
  `tax_name` varchar(50) DEFAULT NULL,
  `tax_rate` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_settings
$sql="CREATE TABLE IF NOT EXISTS `tbl_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` text DEFAULT NULL,
  `system_name` varchar(50) DEFAULT NULL,
  `starting_year` varchar(10) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `city_id` int(11) NULL DEFAULT NULL,
  `state_id` int(11) NULL DEFAULT NULL,
  `country_id` int(11) NULL DEFAULT NULL,
  `logo_image` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `paypal_id` varchar(50) DEFAULT NULL,
  `date_format` varchar(255) DEFAULT NULL,
  `currancy` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2";
$data=$conn->exec($sql);
$sql ="INSERT INTO `tbl_settings` (`id`, `address`, `system_name`, `starting_year`, `phone_number`, `email`, `city_id`, `state_id`, `country_id`, `logo_image`, `cover_image`, `paypal_id`, `date_format`, `currancy`, `created_at`, `updated_at`) VALUES
(1, '', '$systemname', '', '', '$s_email', '783', '12', '101', 'SV0KVFfZjW2ETXN.png', 'YgTd1CqSnCkWokh.jpg', '', 'Y-m-d', '53', '2018-04-17 08:14:38', '2018-04-14 02:04:32')";
$data=$conn->exec($sql);
//tbl_states
$sql="CREATE TABLE IF NOT EXISTS `tbl_states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
 `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4121";
$data=$conn->exec($sql);
$sql ="INSERT INTO `tbl_states` (`id`, `name`, `country_id`) VALUES
(3796, 'Abu Dabi', 229),
(3797, 'Sharjah', 229),
(3798, 'Ras AL Khaymah', 229),
(3799, 'Ajman', 229),
(3800, 'Al Ain', 229),
(3801, 'Fujairah', 229),
(3802, 'Dubai', 229)";
$data=$conn->exec($sql);
//tbl_stock_records
$sql="CREATE TABLE IF NOT EXISTS `tbl_stock_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `no_of_stoke` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_vehicles
$sql="CREATE TABLE IF NOT EXISTS `tbl_vehicles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicletype_id` int(11) DEFAULT NULL,
  `chassisno` varchar(255) DEFAULT NULL,
  `vehiclebrand_id` int(11) DEFAULT NULL,
  `modelyear` varchar(255) DEFAULT NULL,
  `fuel_id` int(11) DEFAULT NULL,
  `modelname` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `odometerreading` varchar(255) DEFAULT NULL,
  `dom` varchar(255) DEFAULT NULL,
  `gearbox` varchar(255) DEFAULT NULL,
  `gearboxno` varchar(255) DEFAULT NULL,
  `engineno` varchar(255) DEFAULT NULL,
  `enginesize` varchar(255) DEFAULT NULL,
  `keyno` varchar(255) DEFAULT NULL,
  `engine` varchar(255) DEFAULT NULL,
  `nogears` varchar(255) DEFAULT NULL,
  `registration_no` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_vehicle_brands
$sql="CREATE TABLE IF NOT EXISTS `tbl_vehicle_brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) DEFAULT NULL,
  `vehicle_brand` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_vehicle_colors
$sql="CREATE TABLE IF NOT EXISTS `tbl_vehicle_colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) DEFAULT NULL,
  `color` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_vehicale_colors_ibfk_1` (`vehicle_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//tbl_vehicle_discription_records
$sql="CREATE TABLE `tbl_vehicle_discription_records` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`vehicle_id` int(11) DEFAULT NULL,
	`vehicle_description` text,
	`created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
$data=$conn->exec($sql);
//tbl_vehicle_images
$sql="CREATE TABLE IF NOT EXISTS `tbl_vehicle_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);

$sql="CREATE TABLE IF NOT EXISTS `tbl_vehicle_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_type` varchar(255) DEFAULT NULL,
 `created_at` timestamp NULL DEFAULT NULL,
 `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
$data=$conn->exec($sql);
//users
$sql="CREATE TABLE `users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`lastname` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
	`display_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
	`gender` tinyint(1) DEFAULT NULL,
	`birth_date` date DEFAULT NULL,
	`email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`contact_person` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`mobile_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`landline_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`address` text COLLATE utf8_unicode_ci,
	`image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`join_date` date DEFAULT NULL,
	`designation` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
	`left_date` date DEFAULT NULL,
	`account_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`ifs_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`branch_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`tin_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`pan_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`gst_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`country_id` int(11) DEFAULT NULL,
	`state_id` int(11) DEFAULT NULL,
	`city_id` int(11) DEFAULT NULL,
	`role` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
	`language` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`timezone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`custom_field` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
	`created_at` timestamp NULL DEFAULT NULL,
	`updated_at` timestamp NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
$data=$conn->exec($sql);

$sql ="INSERT INTO `users` (`id`, `name`, `lastname`, `display_name`, `gender`, `birth_date`, `email`, `contact_person`, `password`, `mobile_no`, `landline_no`, `address`, `image`, `join_date`, `designation`, `left_date`, `account_no`, `ifs_code`, `branch_name`, `tin_no`, `pan_no`, `gst_no`, `country_id`, `state_id`, `city_id`, `role`, `language`, `timezone`, `custom_field`, `remember_token`, `created_at`, `updated_at`) VALUES
(1,'$f_name', '$l_name', '', 0, NULL, '$email', '','$password', '', '','$address', 'system_m.png', NULL, '', NULL, '', '', '', '', '', '', 0, 0, 0, 'admin', 'en', 'UTC', '', 'Qe5y0kobcAwv9jk22AMyfKGBIT4Til3P9l8vSBpvx0zl8XVpuhzujpbPbpSq', NULL, NULL)";

$data=$conn->exec($sql);

	file_put_contents('installed.txt', date('Y-m-d, H:i:s'));

	return redirect('/');
	}
}
