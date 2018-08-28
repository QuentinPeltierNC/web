<?php

namespace Drupal\netcom\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

/**
 * Provides a 'NetcomBlock' block.
 *
 * @Block(
 *  id = "netcom_block",
 *  admin_label = @Translation("Netcom block"),
 * )
 */
class NetcomBlock extends BlockBase
{

    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration()
    {
        return [
            ] + parent::defaultConfiguration();
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state)
    {
        $form['description'] = [
            '#type' => 'text_format',
            '#title' => $this->t('description'),
            '#default_value' => $this->configuration['description'],
            '#weight' => '10',
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state)
    {
        $this->configuration['description'] = $form_state->getValue('description');
    }

    /**
     * {@inheritdoc}
     */
    public function build()
    {

        $build = [];

        $actusid = \Drupal::entityQuery("node")
            ->condition("type", "article", "=")
            ->sort("created", "DESC")
            ->range(0,5)
            ->execute();

        $title = "";
        foreach ($actusid as $currentactuid) {
            $actu = Node::load($currentactuid);
            $title .= '<li>' . $actu->getTitle() . '</li>';
        }

        $build['netcom_block_description']['#markup'] = '<ul>' . $title . '</ul>';

        return $build;
    }

}
