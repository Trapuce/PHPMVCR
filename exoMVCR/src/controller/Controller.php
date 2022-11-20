<?php


/**
 * Computer controller
 */
class Controller
{
	protected $view;
	protected $db;
	protected $currentComputerBuilder;
	protected $modifiedComputerBuilders;

	/**
	 * constructor function
	 * @param View       $view MainView instance
	 * @param ComputerStorage $db   database instance
	 */
	public function __construct($view, ComputerStorage $db)
	{
		$this->view = $view;
		$this->db = $db;
		$this->currentComputerBuilder = key_exists('currentComputerBuilder', $_SESSION) ? $_SESSION['currentComputerBuilder'] : null;
		$this->modifiedComputerBuilders = key_exists('modifiedComputerBuilders', $_SESSION) ? $_SESSION['modifiedComputerBuilders'] : array();

	}
	public function __destruct() {
		$_SESSION['currentComputerBuilder'] = $this->currentComputerBuilder;
		$_SESSION['modifiedComputerBuilders'] = $this->modifiedComputerBuilders;
	}
	public function getdb()
	{
		return $this->db;
	}

	public function showInformationId($id)
	{

		$computer = $this->db->read($id);
		if ($computer != null) {
			$this->view->makeComputerPage($id, $this->db->read($id));
		} else {
			$this->view->makeUnknownComputerPage();
		}
	}
	/**
	 * get all computers from database
	 */
	public function showList()
	{
		$this->view->makeListPage($this->db->readAll());
	}

	/**
	 * save new computer if the information entered is valid, else redirect to form
	 * @param array $data       $_POST data
	 */
	public function saveNewComputer(array $data , $imageData)
	{
		$this->currentComputerBuilder = new ComputerBuilder($data , $imageData);
		if ($this->currentComputerBuilder->isValid()) {

			$computerNew = $this->currentComputerBuilder->createComputer();
			$id = $this->db->create($computerNew);
			$this->currentComputerBuilder = null;
			$this->view->displayComputerCreationSuccess($id);
		} else {
			//$_SESSION['currentComputerBuilder'] = $computerbuilder;
			  
			$this->view->displayComputerNotCreatedPage();
		}
	}

	public function askComputerDeletion($id)
	{
		$computer = $this->db->read($id);
		if ($computer !== null) {
			$this->view->makeComputerDeletionPage($id, $computer);
		} else {
			$this->view->makeUnknownComputerPage();
		}
	}
	/**
	 * delete computer
	 * @param string $id
	 */
	public function deleteComputer($id)
	{
		$this->db->delete($id);
		$this->view->displayComputerDeletionSuccess($id);
	}
	/**
	 * create an instance of modify computer builder and redirect to the computer
	 *  modification form
	 * @param string $id
	 */
	public function askComputerUpdate($id)
	{
		if (key_exists($id,$this->modifiedComputerBuilders)) {
			/* Préparation de la page de formulaire */
			$this->view->makeModifyComputer($id, $this->modifiedComputerBuilders[$id]);
		} else {
			/* On récupère en BD la couleur à modifier */
			$computer = $this->db->read($id);
			if ($computer === null) {
				$this->view->makeUnknownComputerPage();
			} else {
				/* Extraction des données modifiables */
				$data = ComputerBuilder::builderFromToComputer(new Computer($computer["name"], $computer["mark"], $computer["features"], $computer["description"] , $computer["image"]));
				$computerbuilder = new ComputerBuilder($data);
				/* Préparation de la page de formulaire */
				$this->view->makeModifyComputer($id, $computerbuilder);
			}
		}
	}

	/**
	 * register modified computer if the information entered is valid, else redirect to form
	 * @param string $id
	 * @param array $data       $_POST data
	 */
	public function updateComputer($id, $data , $imageData)
	{
		$computer = $this->db->read($id);

		if ($computer == null) {
			$this->view->makeUnknownComputerPage();
		} else {
			$computerbuilder = new ComputerBuilder($data, $imageData);

			if ($computerbuilder->isValid()) {
				$tmp = new Computer($computer["name"], $computer["mark"], $computer["features"], $computer["description"],$computer["image"]);
				$computerbuilder->updateComputer($tmp);

				$ok = $this->db->update($id, $tmp);

				if ($ok) {
					$c = $this->db->read($id);
					unset($this->modifiedComputerBuilders[$id]);
					$this->view->displayComputerModifiedPage($id);
				} else {
					throw new Exception("Identifier has disappeared?!");
				}
			} else {
				$this->modifiedComputerBuilders[$id] = $computerbuilder;
				$this->view->displayComputerNotModifiedPage($id);
			}
		}
	}
	/**
	 * newComputer creates a new computer builder and redirects 
	 * to create a computer form
	 */
	public function newComputer()
	{
		
		if ($this->currentComputerBuilder === null) {
			$this->currentComputerBuilder = new ComputerBuilder();
		}
		$this->view->makeCreateComputerPage($this->currentComputerBuilder);
	}
}
