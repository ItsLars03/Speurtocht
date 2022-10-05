const { Router } = require('express')
const { PrismaClient } = require('@prisma/client')
const prisma = new PrismaClient()

const router = Router()

router.get("/:scavengerhuntid", async (req, res) => {
    // const { scavengerhuntId}
})



module.exports = router