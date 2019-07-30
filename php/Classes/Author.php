<?php
namespace lchristensen7\ObjectOrient;
require_once ("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;
/**
 * Creating class table.
 *
 * Setting up class for author tables.
 *
 * @author Lariah Christensen <lchristensen7@cnm.edu>
 * @version 4.0.0
 **/

class Author implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this author; this is the primary key
	 * @var Uuid $authorId
	 **/

	private $authorId;
	/**
	 * create URL for this author; this is a unique index
	 * @var string $authorAvatarUrl
	 **/

	private $authorAvatarUrl;
	/**
	 * token handed out to verify author
	 * @var $authorActivationToken
	 **/

	private $authorActivationToken;
	/**
	 * email for this Author; this is a unique index
	 * @var string $authorEmail
	 **/

	private $authorEmail;
	/**
	 * hash for author password
	 * @var $authorHash
	 **/

	private $authorHash;
	/**
	 * name created for this author; this is a unique index
	 * @var string $authorUsername
	 **/

	private $authorUsername;
	/**
	 * constructor for this Author
	 *
	 * @param string|Uuid $AuthorId id of this Author or null if a new Author
	 * @param string $newAuthorAvatarUrl string containing URL or Author
	 * @param string $newAuthorActivationToken token handed out to verify author
	 * @param string $newAuthorEmail string containing email
	 * @param string $newAuthorHash string containing password hash
	 * @param string $newAuthorUsername string containing name of author
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if a data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	public function __construct($newAuthorId, string $newAuthorAvatarUrl, string $newAuthorActivationToken, string $newAuthorEmail, string $newAuthorHash, string $newAuthorUsername) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for author id
	 *
	 * @return Uuid value of author id
	 **/
	public function getAuthorId() : Uuid {
		return($this->AuthorId);
	}

	/**
	 * mutator method for author id
	 *
	 * @param Uuid|string $newAuthorId new value of author id
	 * @throws \RangeException if $newAuthorId is not positive
	 * @throws \TypeError if $newAuthorId is not a uuid or string
	 **/
	public function setAuthorId( $newAuthorId) : void {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the author id
		$this->authorId = $uuid;
	}

	/**
	 * accessor method for author avatar URL
	 *
	 * @return string
	 **/
	public function getAuthorAvatarUrl() : Uuid{
		return($this->authorAvatarUrl);
	}

	/**
	 * mutator method for author Avatar URL or null ifno author avatar URL
	 *
	 * @param string | Uuid $newAuthorAvatarUrl new value of author profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newAuthorProfileId is not an integer
	 **/

	public function setAuthorProfileId( $newAuthorProfileId) : void {
		try {
			$uuid = self::validateUuid($newAuthorProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the profile id
		$this->authorProfileId = $uuid;
	}

	/**
	 * accessor method for author content
	 *
	 * @return string value of author content
	 **/
	public function getAuthorContent() : string {
		return($this->authorContent);
	}

	/**
	 * mutator method for author content
	 *
	 * @param string $newAuthorContent new value of author content
	 * @throws \InvalidArgumentException if $newAuthorContent is not a string or insecure
	 * @throws \RangeException if $newAuthorContent is > 140 characters
	 * @throws \TypeError if $newAuthorContent is not a string
	 **/
	public function setAuthorContent(string $newAuthorContent) : void {
		// verify the author content is secure
		$newAuthorContent = trim($newAuthorContent);
		$newAuthorContent = filter_var($newAuthorContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorContent) === true) {
			throw(new \InvalidArgumentException("author content is empty or insecure"));
		}

		// verify the author content will fit in the database
		if(strlen($newAuthorContent) > 140) {
			throw(new \RangeException("author content too large"));
		}

		// store the author content
		$this->authorContent = $newAuthorContent;
	}

	/**
	 * accessor method for author date
	 *
	 * @return \DateTime value of author date
	 **/
	public function getAuthorDate() : \DateTime {
		return($this->authorDate);
	}

	/**
	 * mutator method for author date
	 *
	 * @param \DateTime|string|null $newAuthorDate author date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newAuthorDate is not a valid object or string
	 * @throws \RangeException if $newAuthorDate is a date that does not exist
	 **/
	public function setAuthorDate($newAuthorDate = null) : void {
		// base case: if the date is null, use the current date and time
		if($newAuthorDate === null) {
			$this->authorDate = new \DateTime();
			return;
		}

		// store the like date using the ValidateDate trait
		try {
			$newAuthorDate = self::validateDateTime($newAuthorDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->authorDate = $newAuthorDate;
	}

	/**
	 * inserts this Author into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO author(authorId,authorProfileId, authorContent, authorDate) VALUES(:authorId, :authorProfileId, :authorContent, :authorDate)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->authorDate->format("Y-m-d H:i:s.u");
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorProfileId" => $this->authorProfileId->getBytes(), "authorContent" => $this->authorContent, "authorDate" => $formattedDate];
		$statement->execute($parameters);
	}


	/**
	 * deletes this Author from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this Author in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE author SET authorProfileId = :authorProfileId, authorContent = :authorContent, authorDate = :authorDate WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);


		$formattedDate = $this->authorDate->format("Y-m-d H:i:s.u");
		$parameters = ["authorId" => $this->authorId->getBytes(),"authorProfileId" => $this->authorProfileId->getBytes(), "authorContent" => $this->authorContent, "authorDate" => $formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * gets the Author by authorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId author id to search for
	 * @return Author|null Author found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : Author {
		// sanitize the authorId before searching
		try {
			$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT authorId, authorProfileId, authorContent, authorDate FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the author id to the place holder in the template
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);

		// grab the author from mySQL
		try {
			$author = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$author = new author($row["authorId"], $row["authorProfileId"], $row["authorContent"], $row["authorDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($author);
	}

	/**
	 * gets the author by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorProfileId profile id to search by
	 * @return \SplFixedArray SplFixedArray of authors found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAuthorByAuthorProfileId(\PDO $pdo, $authorProfileId) : \SplFixedArray {

		try {
			$authorProfileId = self::validateUuid($authorProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT authorId, authorProfileId, authorContent, authorDate FROM author WHERE authorProfileId = :authorProfileId";
		$statement = $pdo->prepare($query);
		// bind the author profile id to the place holder in the template
		$parameters = ["authorProfileId" => $authorProfileId->getBytes()];
		$statement->execute($parameters);
		// build an array of authors
		$authors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$author = new Author($row["authorId"], $row["authorProfileId"], $row["authorContent"], $row["authorDate"]);
				$authors[$authors->key()] = $author;
				$authors->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($authors);
	}

	/**
	 * gets the Author by content
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $authorContent author content to search for
	 * @return \SplFixedArray SplFixedArray of Authors found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAuthorByAuthorContent(\PDO $pdo, string $authorContent) : \SplFixedArray {
		// sanitize the description before searching
		$authorContent = trim($authorContent);
		$authorContent = filter_var($authorContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($authorContent) === true) {
			throw(new \PDOException("author content is invalid"));
		}

		// escape any mySQL wild cards
		$authorContent = str_replace("_", "\\_", str_replace("%", "\\%", $authorContent));

		// create query template
		$query = "SELECT authorId, authorProfileId, authorContent, authorDate FROM author WHERE authorContent LIKE :authorContent";
		$statement = $pdo->prepare($query);

		// bind the author content to the place holder in the template
		$authorContent = "%$authorContent%";
		$parameters = ["authorContent" => $authorContent];
		$statement->execute($parameters);

		// build an array of authors
		$authors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$author = new author($row["authorId"], $row["authorProfileId"], $row["authorContent"], $row["authorDate"]);
				$authors[$authors->key()] = $author;
				$authors->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($authors);
	}

	/**
	 * gets all Autors
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Authors found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllAuthors(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT authorId, authorProfileId, authorContent, authorDate FROM author";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of authors
		$authors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$author = new author($row["authorId"], $row["authorProfileId"], $row["authorContent"], $row["authorDate"]);
				$authors[$authors->key()] = $author;
				$authors->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($authors);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["authorId"] = $this->authorId->toString();
		$fields["authorProfileId"] = $this->authorProfileId->toString();

		//format the date so that the front end can consume it
		$fields["authorDate"] = round(floatval($this->authorDate->format("U.u")) * 1000);
		return($fields);
	}
}