import { Router } from 'express'
import { PrismaClient } from '@prisma/client'
const prisma = new PrismaClient()

const router = Router()


router.post("/", async (req, res) => {

    const { password, email } = req.body

    try {
        const user = await prisma.user.create({
            data: {
                nickname: "test",
                password,
                email
            }

        })
    } catch (error) {
        console.error(error)
    }


    // console.dir(allUsers, { depth: null })


    console.log("coming in from /login body ->", req.body)
})


export default router