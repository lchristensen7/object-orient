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
		return($this->authorId);
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
	public function getAuthorAvatarUrl() {
		return($this->authorAvatarUrl);
	}

	/**
	 * mutator method for author Avatar URL or null ifno author avatar URL
	 *
	 * @param string | Uuid $newAuthorAvatarUrl new value of author profile id
	 * @throws \RangeException if $newAuthorAvatarUrl is not positive
	 * @throws \TypeError if $newAuthorAvatarUrl is not a string
	 **/

	public static function setAuthorAvatarUrl ( string $newAuthorAvatarUrl) : void {
		$newAuthorAvatarUrl = trim ($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
// verify the avatar URL will fit in the database
if (strlen($newAuthorAvatarUrl) > 255) {
	throw(new \RangeException ("image content too large"));
}
		//store the image content
		$this->authorAvatarUrl=$newAuthorAvatarUrl;
	}

	/**
	 * accessor method for author activation token
	 *
	 * @return string value of author activation token
	 **/
	public function getAuthorActivationToken() : string {
		return($this->authorActivationToken);
	}

	/**
	 * mutator method for authoractivation token
	 *
	 * @param string $newAuthorActivationToken
	 * @throws \InvalidArgumentException if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if activation token is not a string
	 **/

	public function setAuthorActivationToken(string $newAuthorActivationToken) : void {
		if($newAuthorActivationToken === null) {
			$this->authorActivationToken = null;
			return;
		}
		$newAuthorActivationToken = strtolower (trim($newAuthorActivationToken));
		if (ctype_xdigit($newAuthorActivationToken)=== false) {
			throw (new\RangeException("user activation is not valid"));
		}

		// make sure user activation token is only 32 characters
		if(strlen($newAuthorActivationToken) === false) {
			throw(new \RangeException("user activation token has to be 32"));
		}
		$this->authorActivationToken = $newAuthorActivationToken;
	}

	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 **/
	public function getAuthorEmail() : string {
		return($this->authorEmail);
	}

	/**
	 * mutator method for email
	 *
	 * @param string $newAuthorEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws \RangeException if $newAuthorEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 **/

	public function setAuthorEmail($newAuthorEmail = null) : void {
		// verify the email is secure
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
		if(EMPTY ($newAuthorEmail) === true) {
			throw (new \InvalidArgumentException("author email is empty or insecure"));
		}
		//verify the email will fit in the database
		if(strlen($newAuthorEmail) > 128) {
			throw (new \RangeException("author email is too large"));
		}
		//store the amil
		$this->authorEmail = $newAuthorEmail;
	}

	/**
	 * accessor method for obtaining authorHash
	 * @var string authorHash
	 **/

	public function getAuthorHash() : string {
		return ($this->authorHash);
	}
	/**
	 * mutator for Hash/passwrd
	 *
	 * @param string $newProfileHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */

	public function setAuthorHash(string $newAuthorHash): void {
		//enforce that the hash is properly formatted
		$newAuthorHash = trim($newAuthorHash);
		if(empty($newAuthorHash) === true) {
			throw(new \InvalidArgumentException("author password hash empty or insecure"));
		}
		//enforce the hash is really an Argon hash
		$authorHashInfo = password_get_info($newAuthorHash);
		if($authorHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("author hash is not a valid hash"));
		}
		//enforce that the hash is exactly 97 characters.
		if(strlen($newAuthorHash) !== 97) {
			throw(new \RangeException("author hash must be 97 characters"));
		}
		//store the hash
		$this->authorHash = $newAuthorHash;
	}

	/*
 * accessor method for authorUsername
	 * @return string authorUsername
 **/

	public function getAuthorUsername() :string {
		return $this->authorUsername;
	}

	/**
	 * mutator for author user name
	 *
	 * @param string $newAuthorUsername provided by user
	 * @throws \RangeException
	 * @throws \TypeError if value type is not correct
	 */

	public function setAuthorUsername(string $newAuthorUsername): void {
		//verification the handle is secure//
		$newAuthorUsername = trim($newAuthorUsername);
		$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING);

		if (empty($newAuthorUsername)=== true) {
		throw (new \InvalidArgumentException("author at handle is empty or insecure"));
	}
		if(strlen($newAuthorUsername) > 32) {
			throw(new \RangeException(" Username too large"));
		}

		$this->authorUsername = $newAuthorUsername;
	}


	/**
	 * inserts this author into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDO Exception when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO author(authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername) 
		VALUES(:authorId, :authorAvatarUrl, :authorActivationToken, :authorEmail, :authorHash, :authorUsername)";
		$statement = $pdo->prepare($query);

		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl,"authorActivationToken"=> $this->authorActivationToken,
			"authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" =>$this->authorUsername ];
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
		$query = "UPDATE author SET authorAvatarUrl = :authorAuthorUrl, authorActivationToken = :authorActivationToken, authorEmail = :authorEmail, authorHash = :authorHash, authorUsername = :authorUsername WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["authorAvatarUrl" => $this->authorAvatarUrl,"authorActivationToken"=> $this->authorActivationToken,
			"authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" =>$this->authorUsername ];
		$statement->execute($parameters);
	}

	/**
	 * deletes this author from mySQL
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
	 * gets Author by authorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId author id to search for
	 * @return Author|null Author found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 *
	 **/

	public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : Author {
		// sanitize the authorId before searching//
		try {
			$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}


		// create query template
		$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername FROM author WHERE authorId LIKE = :authorId";
		$statement = $pdo->prepare($query);

		//bind the author id to the place holder in the template
		$parameters = [authorId => $authorId->getBytes()];
		$statement->execute($parameters);

		// grab the author from mySQL//
		try {
			$author = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$author = new author($row[authorId], $row[authorAvatarUrl], $row[authorActivationToken], $row[authorEmail],
				$row[authorHash], $row[authorUsername]);
			}

		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($author);
	}

	/**
	 **
	 * get authors by get by user name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Authors found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getAllAuthors(\PDO $pdo) : \SPLFixedArray {

		// create query template
		$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash, authorUsername FROM author";
		$statement = $pdo->prepare($query);
		$statement->execute();
		
		// build an array of Authors
		$author = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$author = new author($row[authorId], $row[authorAvatarUrl], $row[authorActivationToken], $row[authorEmail], $row[authorHash], $row[authorUsername]);
				$authors [$authors->key()] = $author;
				$authors->next();

			} catch(\Exception $exception) {

				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($author);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["authorId"] = $this->authorId->toString();
		unset($fields["authorActivationToken"]);
		unset($fields["authorHash"]);
		return ($fields);
		}
}