import { Router } from "express";
import mailer from 'nodemailer'


const router = Router()






router.post("/", async (req, res) => {
    console.log("test???")
    // let testAccount = await nodemailer.createTestAccount();
    let transporter = nodemailer.createTransport({
        host: "mail.antagonist.nl",
        port: 465,
        secure: true, // true for 465, false for other ports
        auth: {
            user: "p11k3t3@lesonline.nu", // generated ethereal user
            pass: "e7mUNBssyG", // generated ethereal password
        },
    });

    let info = await transporter.sendMail({
        from: 'p11k3t3@lesonline.nu', // sender address
        to: "thimosietsma@gmail.com", // list of receivers
        subject: "Deelnemen aan de speurtocht", // Subject line
        text: "test?", // plain text body
        html: "<html>Zet hier het bericht</html>", // html body
    });

    res.status(200).json(info)
})


export default Router