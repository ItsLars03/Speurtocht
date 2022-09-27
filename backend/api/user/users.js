import { Router } from 'express'
import { PrismaClient } from '@prisma/client'

const prisma = new PrismaClient()
const router = Router()


router.get("/:id", async (req, res) => {
    const { id } = req.params

    const data = await prisma.user.findFirst({
        where: {
            userId: parseInt(id)
        },
        select: {
            nickname: true,
            email: true,
            password: true,

            scavengerHunt: true
        }
    })

    res.status(200).json(data)
})



export default router