<?php
/******************************************
 | Class name  : Authentication.class.php |
 | Last Modify : Jan 2013                 |
 | By          : Narong Rammanee          |
 | E-mail      : ranarong@live.com        |
 ******************************************/

class Authentication extends DBConnection
{
    /**
     * __construct — Initialization
     *
     * @return No value is returned.
     */
    public function __construct($pdo=null)
    {
        parent::__construct();
    }

    public function login($username, $passwd, $memPasswd, $is_auto=null)
    {
        $_SESSION['username'] = $username;
        $passwd = $is_auto ? $passwd : sha1($username.$passwd);

        $sql = "
            SELECT
                    sysuser.username,
                    sysrole.rolecode
            FROM
                    sysrole
            INNER JOIN sysmember ON sysmember.roleid = sysrole.roleid
            INNER JOIN sysuser ON sysmember.username = sysuser.username
            WHERE sysuser.username = '{$username}' 
                AND sysuser.\"password\" ='{$passwd}'
        ";

        $sth = $this->db->prepare($sql);

        $sth->execute();

        $result = $sth->fetchObject();

        if ($result !== false) {
            //----------------------------------------------
            $sql = "
                SELECT * FROM responsible_area WHERE username = '{$username}'
            ";

            $sth = $this->db->prepare($sql);
            $sth->execute();

            $resp = $sth->fetch(PDO::FETCH_OBJ);
            //----------------------------------------------
            $sql = "
                SELECT
					prv.province_id
                    , prv.province_name
                    , prv.short_name
                    , prv.phase
                    , prv.phase_edit
                    , prv.has_track
                    , prv.has_video
                    , prv.hidden_seminar
                    , gpr.bounds
                FROM
                    province prv LEFT JOIN
                    dblink(
                        'dbname=protopj user=postgres password=".DB_PASS."',
                        'SELECT pro_code, ST_AsText(ST_Envelope(the_geom)) AS bounds FROM gis_province'
                    ) AS gpr(pro_code INT, bounds TEXT) ON  prv.province_id = gpr.pro_code
                WHERE 1=1
                    AND phase = " . $_SESSION['phase'] . "
                    AND enabled IS TRUE
            ";
			//echo "$sql";exit;
            if (isset($_SESSION['phase_edit'])) {
                $sql .= "
                    AND phase_edit is TRUE
                ";
            }

            if ($resp->responsible_type !== 'ALL') {
                $sql .= "
                    AND prv.province_id = {$resp->area_id}
                ";
            }

            $sql .= "
                ORDER BY prv.province_name ASC
            ";

            $sth = $this->db->prepare($sql);
            $sth->execute();

			//--> if login you will be get this session province. if not log in you will be get on Integration class.
            $_SESSION['provinces'] = $sth->fetchALL(PDO::FETCH_ASSOC);
			

            $sql = "
                SELECT 
                    DISTINCT key_alias
                FROM
                    sysmodule INNER JOIN  sysoperation ON  sysoperation.moduleid =  sysmodule.id
                    INNER JOIN  sysaccess ON  sysoperation.id =  sysaccess.operationid
                INNER JOIN  sysrole ON  sysaccess.roleid =  sysrole.roleid
                WHERE sysoperation.actionid >= 5 AND
                    sysmodule.parentid = 106 AND
                    sysrole.rolecode in ('{$result->rolecode}')
            ";

            $sth = $this->db->prepare($sql);
            $sth->execute();

            $result = $sth->fetchALL(PDO::FETCH_ASSOC);

            $_SESSION['layers_group'] = self::recursive_implode($result);

            if (!isset($_COOKIE['siteAuth']) && $memPasswd == 1) {
                setcookie ("siteAuth", 'usr=' . $username . '&hash=' . $passwd . '&memPasswd=' . $memPasswd . '&phase=' . $phase, time() + (3600 * 24 * 30 * 12));
            }

            return true;
        } else {
            return false;
        }
    }

    public function logout()
    {
        session_destroy();

        return true;
    }

    public function autoLogin ($phase)
    {
        if (isset($_COOKIE['siteAuth'])) {
            parse_str($_COOKIE['siteAuth']);

            $loged_in = self::login ($usr, $hash, $memPasswd, $phase, true);;

            if ($loged_in) {
                header('Location: http://' . $_SERVER['HTTP_HOST'] . PROJ_NAME);
            }

        } else {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . PROJ_NAME . "/login.php?phase=" . $phase);
        }
    }

    public function recursive_implode(array $array, $glue = ',', $include_keys = false, $trim_all = true)
    {
        $glued_string = '';

        // Recursively iterates array and adds key/value to glued string
        array_walk_recursive($array, function($value, $key) use ($glue, $include_keys, &$glued_string)
        {
            $include_keys and $glued_string .= $key.$glue;
            $glued_string .= $value.$glue;
        });

        // Removes last $glue from string
        strlen($glue) > 0 and $glued_string = substr($glued_string, 0, -strlen($glue));

        // Trim ALL whitespace
        $trim_all and $glued_string = preg_replace("/(\s)/ixsm", '', $glued_string);

        return (string) $glued_string;
    }
    //--------------------------------------------------------------------------
    public function get_province_track_id()
    {
    //--> no use
        $db_pro = DB_LINK_PROVINCE;
        /*$sql_p ="
            SELECT x.* 
            FROM dblink('{$db_pro}',
                        'SELECT 
                            short_name,
                            province_name,
                            phase,
                            tracking_province_code
                        FROM province
                        ORDER BY province_name'
                            ) AS x(short_name TEXT, province_name TEXT, phase TEXT, tracking_province_code TEXT) 
            WHERE x.short_name IS NOT NULL 
            --LIMIT 1
        ";*/
        $sql_p ="
            SELECT 
				short_name,
				province_name,
				phase,
				tracking_province_code
			FROM province
			ORDER BY province_name
            and short_name IS NOT NULL 
            
        ";
        //echo $sql_p;exit;
        $pro_db = $this->db->query($sql_p)->fetchAll(PDO::FETCH_ASSOC);
        // echo '<pre>'; print_r($sql_p);
        // exit;
        foreach ($pro_db as $key => $value) {
        //     echo '<br />', $value['short_name'];
            $provinces[$value['province_name']] = array($value['tracking_province_code'] , $value['short_name']);
            
        }

        return $provinces;
    }
    //--------------------------------------------------------------------------

    /**
     * __destruct
     * 
     * @return No value is returned.
     */
    public function __destruct() 
    {
        parent::__destruct();
    }
}