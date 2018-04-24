<?php

	class InputSanity{

/*			
			Version 1.0.0
			
			This class does sanity check on user inputs. Simplify checks, all in one sanitizer!
			
		
			Functions:
			
			1)	NoSpecialChar($u_input)
				
				Returns: Boolean
				Arguments: $u_input  (String)
				Conditon: Takes in a string input to check for special char. Returns True if no special char in given string.
		
			2)	check_sqli($u_input)

				Returns: Boolean
				Arguments: $u_input  (String)
				Condition: Takes in a string input. Runs it with mysqli_real_escape_string(). Returns True if resultant string === initial string.

			3)	check_xxs($u_input)

				Returns: Boolean
				Arguments: $u_input  (String)
				Condition: Takes in a string input. Runs it with htmlspecialchars(). Returns True if resultant string === initial string. 

			4) 	bleach_input($u_input)

				Returns: String
				Arguments: $u_input  (String)
				Description: Takes in a string input, sanitizes input with mysqli_real_escape_string() and htmlspecialchars(), and returns the resultant string.
*/

		public $xxs = False;
		public $sqli = False;

		#use env var for database connection!
		private $db_serv = "";
		private $db_user = "";
		private $db_pass = "";
		private $db_name = "";

		function no_special_char($u_input){
			$sql = $this->check_sqli($u_input);
			$xxs = $this->check_xxs($u_input);
			return $sql && $xxs;
		}

		function check_sqli($u_input){
			
			$con=mysqli_connect($this->db_serv,$this->db_user,$this->db_pass,$this->db_name);
			$sanitize = mysqli_real_escape_string($con, $u_input);
			if($u_input === $sanitize){
				$this->sqli = True;
			}
			mysqli_close($con);
			return $this->sqli;
			
		}

		function check_xxs($u_input){
			$new_word = htmlspecialchars($u_input);
			if($u_input === $new_word){
				$this->xxs = True;
			}
			return $this->xxs;
		}

		function bleach_input($u_input){
			$con=mysqli_connect($this->db_serv,$this->db_user,$this->db_pass,$this->db_name);
			$u_input = mysqli_real_escape_string($con, $u_input);
			$u_input = htmlspecialchars($u_input);
			return $u_input;
		}

	}	

?>