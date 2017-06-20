<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\Assignment\NotificationCenter;

use HeimrichHannot\Assignment\AssigneeModel;
use HeimrichHannot\Assignment\Assignment;
use HeimrichHannot\Assignment\AssignmentDataModel;
use HeimrichHannot\Assignment\AssignmentModel;
use HeimrichHannot\Assignment\Util\Assignee;

class Tokens extends \Controller
{
    protected $objMessage;

    protected $arrTokens;

    protected $strLanguage;

    protected $objGatewayModel;

    public function addNotificationCenterTokens($objMessage, &$arrTokens, $strLanguage, $objGatewayModel)
    {
        $this->objMessage      = $objMessage;
        $this->arrTokens       = $arrTokens;
        $this->strLanguage     = $strLanguage;
        $this->objGatewayModel = $objGatewayModel;

        if ($objMessage->addAssignment)
        {
            $this->addAssigneeTokens();
        }

        $arrTokens = $this->arrTokens;

        return true;
    }

    protected function addAssigneeTokens()
    {
        $objAssignment = AssignmentModel::findByPk($this->objMessage->assignmentArchive);

        if ($objAssignment === null)
        {
            return;
        }

        $arrColumns = [];
        $arrValues  = [];
        $arrMapping = deserialize($this->objMessage->assignmentMapping);

        foreach ($arrMapping as $condition)
        {
            if (empty($condition['value']) || empty($condition['field']))
            {
                continue;
            }

            $field = \StringUtil::decodeEntities($condition['field']);
            $value = \Haste\Util\StringUtil::recursiveReplaceTokensAndTags($condition['value'], $this->arrTokens);

            $arrColumns[] = "tl_assignment_data.$field = ?";
            $arrValues[]  = $value;
        }

        if (empty($arrColumns) || empty($arrValues))
        {
            return;
        }

        $objData = AssignmentDataModel::findPublishedBy($arrColumns, $arrValues);

        if ($objData === null)
        {
            return;
        }

        $objAssignees = AssigneeModel::findPublishedByPids($objData->fetchEach('id'));

        if ($objAssignees === null)
        {
            return;
        }

        $arrEmails = [];

        while ($objAssignees->next())
        {
            if (($strEmail = Assignee::getAssigneeEmail($objAssignees->current())) === null)
            {
                continue;
            }

            $arrEmails[] = $strEmail;
        }

        $arrEmails = array_unique(array_filter($arrEmails));

        foreach ($arrEmails as $key => $email)
        {
            $this->arrTokens['assignee_email_' . $key] = $email;
        }

        $this->arrTokens['assignee_emails'] = implode(',', $arrEmails);
    }
}