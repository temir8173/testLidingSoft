<?php
/**
* Item
* 
* testing
* 
* @author Iliyassov Temirlan temir8173@gmail.com
* @version 1.0
*/

final class Item
{

	private int $id;
	private string $name;
	private int $status;
	private bool $changed = false;
	private $connection;


	/**
	 * @param $id
	 * @return
	 */
	public function __construct(int $id)
	{
		$this->id = $id;
		$this->init();
		$this->connectDB();
	}

	private function init()
	{
		$pdo = $this->connection;
		$stmt = $pdo->prepare("SELECT name, status FROM objects WHERE id = :id");
		$stmt->execute(['id' => $id]);
		$result = $stmt->fetch();
		$this->name = $result['name'];
		$this->status = $result['status'];
	}

	/**
	* Соединение с БД
	* @return object
	*/
	private function connectDB()
	{
		$db = ['host' => 'localhost', 'name' => 'test', 'charset' => 'UTF-8'];
		$dsn = "mysql:host=$db['host'];dbname=$db['name'];charset=$db['charset']";
		$opt = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
		$this->connection = new PDO($dsn, 'root', '', $opt);
	}

    public function __get($property)
	{
		if (property_exists($this, $property)) {
			return $this->$property;
		} else {
			throw new Exception('Такого свойства не существует');
		}
	}

	public function __set($property, $value)
	{
		if ( property_exists($this, $property) && $value !== null && $property !== 'id' ) {
			$this->$property = $value;
			$this->changed = true;
		} elseif ($property === 'id') {
			throw new Exception('Нельзя изменить свойство id');
		} else {
			throw new Exception('Такого свойства не существует');
		}
	}

	/**
	* Сохранение в БД
	* @return bool
	*/
	public function save()
	{
		if ($this->changed)
		{
			$pdo = $this->connection;
			$sql = "UPDATE objects SET name=:name, status=:status WHERE id=:id";
			$stmt= $pdo->prepare($sql);
			$result = $stmt->execute([
				'name' => $this->name,
				'status' => $this->status,
				'id' => $this->id
			]);
			return $result;
		}
	}
}