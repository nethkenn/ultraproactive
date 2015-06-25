// <?php namespace App\Classes;
// use Request;
// use DB;
// use Mailchimp;
// use Redirect;


// class CheckMailChimp
// {
// 	protected $mailchimp;
//     protected $listId = 'e9f04e4c84';        // Id of newsletter list

//     /**
//      * Pull the Mailchimp-instance (including API-key) from the IoC-container.
//      */
//     public static function __construct(Mailchimp $mailchimp) 
//     {
//         $this->mailchimp = $mailchimp;
//     }

//     *
//      * Access the mailchimp lists API
     
//     public static function addEmailToList($email) 
//     {
//         try {
//             $this->mailchimp
//                 ->lists
//                 ->subscribe(
//                     $this->listId, 
//                     ['email' => $email]
//                 );
//         } catch (\Mailchimp_List_AlreadySubscribed $e) {
        
//         } catch (\Mailchimp_Error $e) {
            
//         }
//     }

// }
