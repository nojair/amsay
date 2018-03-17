'use strict'

module.exports = function setupMetric (MetricModel, AgentModel) {
  async function findByAgentUuid (uuid) {
    return MetricModel.findAll({
      attributes: [ 'type' ], // como un select type from metrics
      group: [ 'type' ], // agrupar el resultado por tipo para q no se repitan
      include: [{ // para tomar algunos datos de la tabla agent
        attributes: [],
        model: AgentModel,
        where: {
          uuid
        }
      }],
      raw: true // se especifica en "config" de index.js pero como en este caso, la query no acepta esa propiedad global, se debe especificar. Sirve para que la query devuelva el resultado como objeto json
    })
  }

  async function findByTypeAgentUuid (type, uuid) {
    return MetricModel.findAll({
      attributes: [ 'id', 'type', 'value', 'createdAt' ],
      where: {
        type
      },
      limit: 20,
      order: [[ 'createdAt', 'DESC' ]],
      include: [{
        attributes: [],
        model: AgentModel,
        where: {
          uuid
        }
      }],
      raw: true
    })
  }

  async function create (uuid, metric) {
    const agent = await AgentModel.findOne({
      where: { uuid }
    })

    if (agent) {
            // metric.agentId = agent.id // esta línea es lo mismo que la línea de abajo
      Object.assign(metric, { agentId: agent.id })
      const result = await MetricModel.create(metric)
      return result.toJSON()
    }
  }

  return {
    create,
    findByAgentUuid,
    findByTypeAgentUuid
  }
}

// este archivo:
// genera una función que necesita de dos modelos (en este caso de "Metric" y "Agent") para poder retornar métodos WRITE/READ más fáciles de usar (que las queries propias de sequelize) sobre las tuplas de este modelo en la base de datos sql.