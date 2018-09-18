<?php 

Class Contact {
	public $name;
	public $mail;
	public $phone;
	public $contact;

	public function __construct($name, $mail, $number)
	{
		$this->name = $name;
		$this->mail = $mail;
		$this->phone = $number;
		$this->contact =  ['name' => $this->name, 'mail' => $this->mail, 'phone' => $this->phone];
	}
}
Class AddressBook {
	private $contacts = [];

	public function run(){

		echo "taper help pour plus d'info\n";
		while (true) {
			$command = readline("Entrez votre commande : ");
			$line = trim($command);
			AddressBook::isMethod($line);
		}
	}

	private function help()
	{
		$all =  get_class_methods('AddressBook');
		echo "La list de toute des fonctions:\n";
		foreach ($all as $name) {
			echo $name."\n";
		}
	}

	private function isMethod($command)
	{
		if (method_exists('AddressBook', $command)) {
			AddressBook::$command();
		} else {
			echo "Aucune du genre\n";
		}
	}

	protected function list()
	{
		print_r($this->contacts);
	}

	protected function add_contact()
	{
		$name = readline('Nom : ');
		$mail = readline('Mail : ');
		$phone = readline('Numero : ');
		$contact = new Contact($name, $mail, $phone);
		array_push($this->contacts, $contact->contact);
		print_r($this->contacts);
	}

	protected function remove_contact()
	{
		print_r($this->contacts);
		$choice =  readline("Quel(s) contact(s) ? :");
		$all = explode(" ", trim($choice));
		$validate = readline("Etes vous sur de vouloir remove: $choice (Y/N)");
		if ($validate == "Y" || $validate == 'y') {
			foreach ($all as $key => $value) {
				$val = intval($value);
				
				if (array_key_exists($val, $this->contacts)) {
				
					unset($this->contacts[$val]);
				
				} else {
					echo " n'existe pas\n";
				}
				
			}
		} else {
			return null;
		}
	}

	protected function similar($val)
	{
		return ($val == $who);
	}

	protected function search()
	{
		$who = readline("Qui chercher ? ");
		$ar = [];
		// var_dump(array_filter($this->contacts, "similar"));

		for ($i=0; $i < count($this->contacts); $i++) {
			foreach ($this->contacts[$i] as $key => $value) {

				if ($value == $who ) {
					array_push($ar, $this->contacts[$i]);
				}
				
			}
		}
		print_r($ar);
	}

	protected function save()
	{
		$name = readline("Nom file : ");
		$file = fopen("$name.txt", "w");
		$text = "CONTACT \n\n";
		foreach ($this->contacts as $key => $array) {
			$text .= "$key =>\n";
			foreach ($array as $key => $value) {
				$text .= "$key : $value \n";

			}
		}
		fwrite($file ,$text);
		fclose($file);
	}

	protected function exit()
	{
		die;
	}
}
$address_book = new AddressBook();
$address_book->run();