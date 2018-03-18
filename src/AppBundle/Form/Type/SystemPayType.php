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
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Transaction::class
        ));
    }
}