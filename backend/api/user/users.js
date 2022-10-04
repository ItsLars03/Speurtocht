const { Router } = require('express')
const { PrismaClient } = require('@prisma/client')

const prisma = new PrismaClient()
const router = Router()


router.get("/:id", async (req, res) => {
    const { id } = req.params

    try {
        const data = await prisma.user.findFirst({
            where: {
                userId: id
            },
            select: {
                nickname: true,
                email: true,
                password: true,

                scavengerHunt: true
            }
        })

        if (data == null) {
            res.status(404).json({
                success: false,
                message: "Could not find the user with this id."
            })
            return
        }

        res.status(200).json({
            success: true,
            data,
        })
    } catch (error) {
        res.status(500).json({
            success: false,
            message: "Internal server error."
        })
    }
})



export default router