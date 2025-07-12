import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Container } from "@/components/ui/container";
import { Head, Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { toast } from "sonner";
import { useEffect, useRef } from "react";
import useTranslationsStore from "@/stores/translations-store";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";

type VerifyEmailProps = {
  status: string;
};

function VerifyEmail({ status }: VerifyEmailProps) {
  const { trans } = useTranslationsStore();

  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      toast.success(
        trans("verify-email.sent", "We have emailed your verification link."),
      );

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <>
      <Head title={trans("ui.email_verify", "Verify your email")} />
      <Container className="gap-6" asChild={true} variant="centered">
        <Section>
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {trans("ui.email_verify", "Verify your email")}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <Card className="w-[18rem]">
              <CardContent className="grid gap-4">
                <p>
                  {trans(
                    "verify-email.instruction",
                    "Please verify your email address by clicking on the link we just emailed to you.",
                  )}
                </p>
                <p>
                  {trans(
                    "verify-email.prompt",
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
          </SectionContent>
        </Section>
      </Container>
    </>
  );
}

export default VerifyEmail;
