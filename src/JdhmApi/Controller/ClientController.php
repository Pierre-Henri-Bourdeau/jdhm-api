<?php
declare(strict_types=1);

namespace JdhmApi\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use JdhmApi\Entity\Client;
use JdhmApi\Form\Type\ClientType;

/**
* @Extra\Route("/clients", name="homepage")
*/
class ClientController extends FOSRestController
{
    /**
    * This method will return all the clients
    *
    * @ApiDoc(
    *  section="Clients",
    *  resource=true,
    *  description="This method will return all the posts",
    *  statusCodes={
    *      200="Returned when successful",
    *      403="Returned when the user is not authorized",
    *      404={
    *        "Returned when the posts are not found"
    *      }
    * }
    * )
    * @Extra\Route("/")
    * @Extra\Method({"GET"})
    * @Rest\View()
    */
    public function getAllClientsAction()
    {
        $clients = $this->get('doctrine')
                        ->getRepository('JdhmApi\Entity\Client')
                        ->findAll();

        return [
            'data' => $clients
        ];
    }

    /**
    * This method will return one client
    *
    * @ApiDoc(
    *  section="Clients",
    *  resource=true,
    *  description="This method will return one client",
    *  statusCodes={
    *      200="Returned when successful",
    *      403="Returned when the user is not authorized",
    *      404={
    *        "Returned when the posts are not found"
    *      }
    * }
    * )
    * @Extra\Route("/{id}")
    * @Extra\Method({"GET"})
    * @ParamConverter("client", class="JdhmApi\Entity\Client")
    * @Rest\View()
    */
    public function getClientAction(Client $client)
    {
        return [
            'data' => $client
        ];
    }

    /**
    * This method will update a client
    *
    * @ApiDoc(
    *  section="Clients",
    *  resource=true,
    *  description="This method will update a client",
    *  statusCodes={
    *      200="Returned when successful",
    *      403="Returned when the user is not authorized",
    *      404={
    *        "Returned when the posts are not found"
    *      }
    * }
    * )
    * @Extra\Route("/{id}")
    * @Extra\Method({"PUT"})
    * @ParamConverter("client", class="JdhmApi\Entity\Client")
    * @Rest\View()
    */
    public function updateClientAction(Client $client, Request $request)
    {
        //@todo use form, this piece of code is dreadful...
        $em = $this->get('doctrine')->getManager();
        $content = json_decode($request->getContent(), true);

        if (!$content) {
            throw new HttpException("No json data in body", 405);
        }

        $client->setFirstName($content['firstName']);
        $client->setLastName($content['lastName']);
        $client->setEmail($content['email']);

        if (array_key_exists('dateOfBirth', $content) && !empty($content['dateOfBirth'])) {
            $date = \DateTime::createFromFormat('d/m/Y', $content['dateOfBirth']);
            $client->setDateOfBirth($date);
        }

        $em->persist($client);
        $em->flush();

        return [
            'data' => $client
        ];
    }

    /**
    * This method will create a client
    *
    * @ApiDoc(
    *  section="Clients",
    *  resource=true,
    *  description="This method will Create a client",
    *  statusCodes={
    *      200="Returned when successful",
    *      403="Returned when the user is not authorized",
    *      404={
    *        "Returned when the posts are not found"
    *      }
    * }
    * )
    * @Extra\Route("/")
    * @Extra\Method({"POST"})
    * @Rest\View()
    */
    public function createClientAction(Request $request)
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);

        $content = json_decode($request->getContent(), true);

        if (!$content) {
            throw new HttpException("No json data in body", 405);
        }

        $form->submit($content);

        if ($form->isSubmitted() && $form->isValid()) {

            $client->setFirstName($content['firstName']);
            $client->setLastName($content['lastName']);
            $client->setEmail($content['email']);

            if (array_key_exists('dateOfBirth', $content) && !empty($content['dateOfBirth'])) {
                $date = \DateTime::createFromFormat('d/m/Y', $content['dateOfBirth']);
                $client->setDateOfBirth($date);
            }

            $em->persist($client);
            $em->flush();

            return ['data' => 'Ok'];
        }

        return $form;

    }

    /**
    * This method will delete a client
    *
    * @ApiDoc(
    *  section="Clients",
    *  resource=true,
    *  description="This method will delete the client",
    *  statusCodes={
    *      200="Returned when successful",
    *      403="Returned when the user is not authorized",
    *      404={
    *        "Returned when the posts are not found"
    *      }
    * }
    * )
    * @Extra\Route("/{id}")
    * @Extra\Method({"DELETE"})
    * @ParamConverter("client", class="JdhmApi\Entity\Client")
    * @Rest\View()
    */
    public function deleteClientAction(Client $client)
    {
        $em = $this->get('doctrine')->getManager();
        $em->remove($client);
        $em->flush();

        return [
            'status' => 'Ok'
        ];
    }
}
