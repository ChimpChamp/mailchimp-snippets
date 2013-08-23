<?php
//$merge_vars = array('FNAME'=> $contacts->FirstName, 'LNAME'=> $contacts->LastName,'STATE' => $contacts->StateCode, 'LTV' => $contacts->LifetimeValue, 'LASTORDER' => $contacts->LastOrderDate); 

function AddOrUpdate($merge_vars, $email,$listId)
{


	$retval = $api->listMembers($listId, 'subscribed', null, 0, 15000 );
	$listsubscribe = false;

	if ($api->errorCode){
		echo "Unable to load listMembers()!";
		echo "\n\tCode=".$api->errorCode;
		echo "\n\tMsg=".$api->errorMessage."\n";
	} else {
		echo "Members matched: ". $retval['total']. "\n";
		echo "Members returned: ". sizeof($retval['data']). "\n";
		foreach($retval['data'] as $member){
			if ($member['email'] ==  $email)
				$listsubscribe = true;
		}
	}




	$retval = $api->listMembers($listId, 'unsubscribed', null, 0, 15000 );
	$listunsubscribe = false;

	if ($api->errorCode){
		echo "Unable to load listMembers()!";
		echo "\n\tCode=".$api->errorCode;
		echo "\n\tMsg=".$api->errorMessage."\n";
	} else {
		echo "Members matched: ". $retval['total']. "\n";
		echo "Members returned: ". sizeof($retval['data']). "\n";
		foreach($retval['data'] as $member){
			if ($member['email'] ==  $contacts->Email)
				$listunsubscribe = true;
		}
	}



	if ($listsubscribe == true)
	{
		$retval = $api->listUpdateMember($listId, $contacts->Email, $merge_vars, 'html', false);
		echo "----- listUdateMember method was called for ".$contacts->Email ;
	}


	if ($listunsubscribe == false && $listsubscribe == false)	
	{
		$retval = $api->listSubscribe( $listId, $contacts->Email, $merge_vars, "html", false, true);
		echo "----- listSubscribe method was called for ".$contacts->Email ;
	}

			  //$retval = $api->listSubscribe( $listId, $contacts->Email, $merge_vars, "html", false, true);
	if ($api->errorCode){
					// $result = "Unable to load listSubscribe()!\n";
					// $result .= "\tCode=".$api->errorCode."\n";
					// $result .="\tMsg=".$api->errorMessage."\n";
		$result ="---------- ".$contacts->Email." :Could not Subscribe. Msg = ".$api->errorMessage." --------<br />";
	} else {
		$result ="---------- ".$contacts->Email." :Subscribed --------<br />";
	}
	echo $result;
	echo "====================================================<br />";
	flush();	
}
}
?>
