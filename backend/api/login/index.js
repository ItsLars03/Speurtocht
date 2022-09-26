import { Router } from 'express'
import { PrismaClient } from '@prisma/client'
const prisma = new PrismaClient()

const router = Router()


router.post("/", async (req, res) => {

    const { password, email } = req.body

    await prisma.user.create({
        data: {
            nickname: "test",
            password,
            email
        }

    })

    const allUsers = await prisma.user.findMany({
    })

    console.dir(allUsers, { depth: null })


    console.log("coming in from /login body ->", req.body)
})


export default router