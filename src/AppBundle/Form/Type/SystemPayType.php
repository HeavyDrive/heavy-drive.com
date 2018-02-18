<?php
/**
 * Created by PhpStorm.
 * User: hd
 * Date: 14/02/18
 * Time: 11:29
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\Transaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SystemPayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('vads_action_mode', 'text', [
            'data' => 'test',
            "mapped" => false,
        ]);
        $builder->add('vads_amount', 'text', [
            'data' => '3000',
            "mapped" => false,
        ]);
        $builder->add('vads_capture_delay', 'text', [
            'data' => '0',
            "mapped" => false,
        ]);
        $builder->add('vads_ctx_mode', 'text', [
            'data' => 'TEST',
            "mapped" => false,
        ]);
        $builder->add('vads_currency', 'text', [
            'data' => '978',
            "mapped" => false,
        ]);
        $builder->add('vads_page_action', 'text', [
            'data' => 'PAYMENT',
            "mapped" => false,
        ]);
        $builder->add('vads_payment_config', 'text', [
            'data' => 'SINGLE',
            "mapped" => false,
        ]);
        $builder->add('vads_site_id', 'text', [
            'data' => '61078196',
            "mapped" => false,
        ]);
        $builder->add('vads_trans_date', 'text', [
            'data' => '20140526101407',
            "mapped" => false,
        ]);
        $builder->add('vads_trans_id', 'text', [
            'data' => '239848',
            "mapped" => false,
        ]);
        $builder->add('vads_version', 'text', [
            'data' => 'V2',
            "mapped" => false,
        ]);
        $builder->add('signature', 'text', [
            "mapped" => false,
            'data' => 'c78bedd1f25e1231db66b17f4956c6a115140470'
        ]);

        $builder->add('save', SubmitType::class, [
        'label' => 'valider',
        'attr' => array('class' => 'btn btn-default'),
    ]);
    }

    /**
     *  <input type="hidden" name="vads_action_mode" value="INTERACTIVE" />
    <input type="hidden" name="vads_amount" value="3000" />
    <input type="hidden" name="vads_capture_delay" value="0" />
    <input type="hidden" name="vads_ctx_mode" value="TEST" />
    <input type="hidden" name="vads_currency" value="978" />
    <input type="hidden" name="vads_page_action" value="PAYMENT" />
    <input type="hidden" name="vads_payment_config" value="SINGLE" />
    <input type="hidden" name="vads_site_id" value="61078196" />
    <input type="hidden" name="vads_trans_date" value="20140526101407" />
    <input type="hidden" name="vads_trans_id" value="239848" />
    <input type="hidden" name="vads_version" value="V2" />
    <input type="hidden" name="signature" value="32b6928262b55fa06ed3b007a6bf1ae433d76bad"/>
    <input type="submit" name="payer" value="Payer"/>
     */

    /**
    * @param OptionsResolver $resolver
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Transaction::class
        ));
    }
}