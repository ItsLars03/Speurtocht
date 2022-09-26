import { Router } from 'express'
import { PrismaClient } from '@prisma/client'
const prisma = new PrismaClient()

const router = Router()

const emailRegex = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/

router.post("/", async (req, res) => {
    const data = prisma.ScavengerHunt.findAll()
    res.status(200).json({ ...data })
})


export default router