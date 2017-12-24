<?php
/**
 * Author: hanxiaolong
 * Date: 2017/12/23
 * Time: 15:41
 */
class logDb {
    /**
     * 自增id
     * @var int
     */
    private $id;

    /**
     * 服务器id
     * @var int
     */
    private $serverId;

    /**
     * 玩家id
     * @var int
     */
    private $accountId;

    /**
     * 日志类型
     * @var int
     */
    private $type;

    /**
     * 日志内容
     * @var string
     */
    private $content;

    /**
     * 创建时间
     * @var int
     */
    private $createTs;

    public function __construct($serverId, $accountId, $type,
                                $content, $createTs, $id = 0) {
        $this->serverId = $serverId;
        $this->accountId = $accountId;
        $this->type = $type;
        $this->content = $content;
        $this->createTs = $createTs;
        $this->id = $id;
    }

    public static function save() {
        $dbHost = '';
        $dbUserName = '';
        $dbPassWord = '';
        $dbName = '';
        $dbPort = '';
        $dbSocket = '';

        //todo 参数没有默认值,并且传的不全,为何不报错
        $conn = new mysqli($dbHost, $dbUserName, $dbPassWord, $dbName, $dbPort);
        if($conn->connect_error) {
            logFile::log(__METHOD__ . ' cannot connect to mysql, error = ' . $conn->connect_error
                , logFile::LOG_TYPE_ERROR);
        }

        $sql = '';
        $ret = $conn->query($sql);
    }

    public static function get() {
        $dbHost = '';
        $dbUserName = '';
        $dbPassWord = '';
        $dbName = '';
        $dbPort = '';
        $dbSocket = '';

        //todo 参数没有默认值,并且传的不全,为何不报错
        $conn = new mysqli($dbHost, $dbUserName, $dbPassWord, $dbName, $dbPort);
        if($conn->connect_error) {
            logFile::log(__METHOD__ . ' cannot connect to mysql, error = ' . $conn->connect_error
                , logFile::LOG_TYPE_ERROR);
        }

        $sql = '';
        $result = $conn->query($sql);

        //错误处理 todo now
        if($result === false) { //sql语法错误

        }
        if($result->num_rows <= 0) {

        }
    }
}