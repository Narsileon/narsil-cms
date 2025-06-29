import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Heading } from "@/components/ui/heading";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { toast } from "sonner";
import { useEffect, useRef } from "react";
import useTranslationsStore from "@/stores/translations-store";

type VerifyEmailProps = {
  status: string;
};

function VerifyEmail({ status }: VerifyEmailProps) {
  const { trans } = useTranslationsStore();

  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      toast.success(
        trans("email.sent", "We have emailed your verification link."),
      );

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <div className="absolute top-1/2 left-1/2 grid -translate-x-1/2 -translate-y-1/2 transform gap-4">
      <Heading className="text-center" level="h1" variant="h4">
        {trans("ui.email_verify", "Verify your email")}
      </Heading>
      <Card className="w-[18rem]">
        <CardContent className="grid gap-4">
          <p>
            {trans(
              "email.instruction",
              "Please verify your email address by clicking on the link we just emailed to you.",
            )}
          </p>
          <p>
            {trans(
              "email.prompt",
              "If you didn't receive the email, we will gladly send you another.",
            )}
          </p>
          <Button asChild={true}>
            <Link href={route("verification.send")} method="post">
              {trans("ui.send_again", "Send again")}
            </Link>
          </Button>
        </CardContent>
      </Card>
    </div>
  );
}

export default VerifyEmail;
