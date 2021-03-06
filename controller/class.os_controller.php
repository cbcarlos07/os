<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 19/06/2017
 * Time: 16:54
 */
class os_controller
{
    public function get_os_solicitadas($pesquisa, $usuario, $inicio, $fim){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->get_os_solicitadas($pesquisa, $usuario, $inicio, $fim);
        return $teste;
    }

    public function getListSolicitacao( $inicio, $fim ){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getListSolicitacao( $inicio, $fim);
        return $teste;
    }
    public function verificaPapelUsuario( $usuario ){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->verificaPapelUsuario( $usuario );
        return $teste;
    }

    public function getTotalChamados($usuario){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getTotalChamados($usuario);
        return $teste;
    }

    public function verificaSolicitacao( $usuario ){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->verificaSolicitacao($usuario);
        return $teste;
    }

    public function getUltimaSolicitacao( $usuario ){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getUltimaSolicitacao($usuario);
        return $teste;
    }

    public function getListIpoOs(){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getListIpoOs();
        return $teste;
    }

    public function getListEspecialidade(){
        require_once 'dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getListEspecialidade();
        return $teste;
    }

    public function getListMotServ($tipoOs){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getListMotServ( $tipoOs );
        return $teste;
    }

    public function getListOficina($usuario){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getListOficina( $usuario );
        return $teste;
    }

    public function getListOficinas(){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getListOficinas(  );
        return $teste;
    }

    public function getListUsuarioOficina( $oficina ){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getListUsuarioOficina( $oficina );
        return $teste;
    }

    public function getListUsuarios(){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getListUsuarios(  );
        return $teste;
    }

    public function verificaUltimoSolicitante($solicitante){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->verificaUltimoSolicitante($solicitante  );
        return $teste;
    }

    public function getDadosUltimoSolicitante( $solicitante){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getDadosUltimoSolicitante($solicitante  );
        return $teste;
    }

    public function getListSetor(){
        require_once 'dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getListSetor(  );
        return $teste;
    }

    public function getUsuario( $user ){
        require_once 'dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getUsuario( $user);
        return $teste;
    }

    public function insert_chamado($os){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->insert_chamado( $os);
        return $teste;
    }

    public function insert_nova_solicitacao(os $os){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->insert_nova_solicitacao( $os);
        return $teste;
    }

    public function update_chamado($os){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->update_chamado( $os );
        return $teste;
    }

    public function update_solicitacao(os $os){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->update_solicitacao( $os );
        return $teste;
    }

    public function update_situacao($tp_situacao, $cdOs){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->update_situacao( $tp_situacao, $cdOs );
        return $teste;
    }

    public function getSolicitacao( $codigoOs ){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getSolicitacao( $codigoOs );
        return $teste;
    }

    public function verificaUsuario( $usuario){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->verificaUsuario( $usuario );
        return $teste;
    }

    public function get_list_chamados_aguardando(){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->get_chamados_aguardando(  );
        return $teste;
    }

    public function verificaSeTemSolicitacao( $codigoOs ){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->verificaSeTemSolicitacao( $codigoOs );
        return $teste;
    }

    public function getListaResponsaveis(  ){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getListaResponsaveis(  );
        return $teste;
    }

    public function get_total_chamados_aguardando(){
        require_once 'dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->get_total_chamados_aguardando(  );
        return $teste;
    }


    public function get_total_chamados_aguardando1(){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->get_total_chamados_aguardando(  );
        return $teste;
    }
	
	public function getListaMeusChamados( $variavel ){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getListaMeusChamados( $variavel );
        return $teste;
    }

    public function getListaMeusChamadosData( $variavel ){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getListaMeusChamadosData( $variavel );
        return $teste;
    }

    public function getListaMeusServicos( $variavel ){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getListaMeusServicos( $variavel );
        return $teste;
    }

    public function getListFuncionario(){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getListFuncionario(  );
        return $teste;
    }

    public function getTotalMeusChamados( $usuario ){
        require_once 'dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getTotalMeusChamados( $usuario );
        return $teste;
    }

    public function getTotalMeusChamado( $usuario ){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getTotalMeusChamados( $usuario );
        return $teste;
    }

    public function inserirAnexo( $values ){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->inserirAnexo( $values );
        return $teste;
    }

    public function getByPlaqueta( $plaqueta ){

        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getByPlaqueta( $plaqueta );
        return $teste;
    }

    public function getAnexo( $values ){

        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $teste = $os_dao->getAnexo( $values );
        return $teste;

    }

    public function getDataFile( $id ){
        require_once '../dao/class.os_dao.php';
        $os_dao = new os_dao();
        $os_dao->getDataFile( $id );

    }
}