import { Toast } from "@base-ui/react/toast";
import { Link } from "@inertiajs/react";
import { Button } from "@narsil-cms/components/button";
import { CardContent, CardRoot } from "@narsil-cms/components/card";
import { Container } from "@narsil-cms/components/container";
import { Heading } from "@narsil-cms/components/heading";
import { useLocalization } from "@narsil-cms/components/localization";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-cms/components/section";
import { useEffect, useRef } from "react";
import { route } from "ziggy-js";

type VerifyEmailProps = {
  status: string;
  title: string;
};

function VerifyEmail({ status, title }: VerifyEmailProps) {
  const { add } = Toast.useToastManager();
  const { trans } = useLocalization();

  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      add({
        description: trans("verify-email.sent"),
      });

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <Container
      className="h-[inherit] min-h-[inherit] justify-center"
      variant="sm"
      render={
        <SectionRoot className="animate-in py-4 fade-in-0 slide-in-from-bottom-10">
          <SectionHeader>
            <Heading level="h1" variant="h4">
              {title}
            </Heading>
          </SectionHeader>
          <SectionContent>
            <CardRoot className="max-w-sm">
              <CardContent>
                <p>{trans("verify-email.instruction")}</p>
                <p>{trans("verify-email.prompt")}</p>
                <Button
                  render={
                    <Link href={route("verification.send")} method="post">
                      {trans("ui.send_again")}
                    </Link>
                  }
                />
              </CardContent>
            </CardRoot>
          </SectionContent>
        </SectionRoot>
      }
    />
  );
}

export default VerifyEmail;
