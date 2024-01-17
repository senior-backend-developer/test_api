<?php

namespace app\components;

use app\models\Link;
use app\models\User;
use yii\db\StaleObjectException;

class Links
{
    /**
     * @param int $user_id
     * @param int|null $link_id
     * @param string $url
     * @return bool
     */
    public function isUrlExist(int $user_id, ?int $link_id, string $url): bool
    {
        if (is_null($link_id)) {
            return false;
        }
        $links = User::findIdentity($user_id)->allLinks();
        $exist_url = $links[$link_id] ?? null;
        return $exist_url === $url;
    }

    /**
     * @param int $user_id
     * @param string $url_without_get
     * @return Link
     */
    public function create(int $user_id, string $url_without_get): Link
    {
        $dateTime = $this->getDateTime();
        $link = new Link();
        $link->user_id = $user_id;
        $link->creation_datetime = $dateTime;
        $link->save();
        $link->url = $this->createUrl($user_id, $link->id, $dateTime, $url_without_get);
        $link->save();
        return $link;
    }

    /**
     * @param int $user_id
     * @param int $link_id
     * @param string $url_without_get
     * @return Link|null
     */
    public function patch(int $user_id, int $link_id, string $url_without_get)
    {
        $link = Link::findOne($link_id);
        $dateTime = $this->getDateTime();
        $link->creation_datetime = $dateTime;
        $link->url = $this->createUrl($user_id, $link_id, $dateTime, $url_without_get);
        $link->save();
        return $link;
    }

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function delete(int $link_id)
    {
        Link::findOne($link_id)->delete();
    }

    /**
     * @return string
     */
    protected function getDateTime(): string
    {
        return (new \DateTime())->format('Y-m-d H:i:s');
    }

    /**
     * @param int $user_id
     * @param int $link_id
     * @param string $creationDatetime
     * @param string $url_without_get
     * @return string
     */
    protected function createUrl(int $user_id, int $link_id, string $creationDatetime, string $url_without_get): string
    {
        $data = [
            'id' => $link_id,
            'ownerId' => $user_id,
            'creationDatetime' => $creationDatetime,
        ];
        return $url_without_get.'?'.http_build_query($data);
    }
}