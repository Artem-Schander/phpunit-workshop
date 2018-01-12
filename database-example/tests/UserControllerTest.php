<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

class UserControllerTest extends TestCase
{
    use TestCaseTrait;

    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;

    // only instantiate IDatabaseConnection once per test
    private $conn = null;

    /**
     * undocumented function
     *
     * @return void
     * @author Artem Schander
     */
    public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
        }

        return $this->conn;
    }

    /**
     * @return IDataSet
     */
    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(dirname(__FILE__).'/_files/dataset.xml');
    }

    /** @test */
    public function inserting_a_user_to_the_db()
    {
        $data = [
            'first_name' => 'Nick',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
        ];

        $UsersController = $this->getMockBuilder(\App\UsersController::class)->setMethods(['getPDO'])->getMock();
        $UsersController->expects($this->once())->method('getPDO')->willReturn(self::$pdo);
        $UsersController->createUser($data);

        $sql = 'SELECT email, first_name, last_name FROM users';
        $result = self::$pdo->query($sql);

        $this->assertCount(1, $result);

        $statement = self::$pdo->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute([':email' => 'john@doe.com']);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Nick', $result['first_name']);
        $this->assertEquals('Doe', $result['last_name']);
    }
}
