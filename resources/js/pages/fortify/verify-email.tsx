import { Link } from "@inertiajs/react";
import { useEffect, useRef } from "react";
import { toast } from "sonner";
import { route } from "ziggy-js";

import { ButtonRoot } from "@narsil-cms/components/button";
import { Card, CardContent } from "@narsil-cms/components/card";
import { ContainerRoot } from "@narsil-cms/components/container";
import { HeadingRoot } from "@narsil-cms/components/heading";
import { useLabels } from "@narsil-cms/components/labels";
import {
  SectionContent,
  SectionHeader,
  SectionRoot,
} from "@narsil-cms/components/section";

type VerifyEmailProps = {
  status: string;
  title: string;
};

function VerifyEmail({ status, title }: VerifyEmailProps) {
  const { trans } = useLabels();

  const hasStatus = useRef<boolean>(false);

  useEffect(() => {
    if (status && !hasStatus.current) {
      toast.success(trans("verify-email.sent"));

      hasStatus.current = true;
    }
  }, [status]);

  return (
    <ContainerRoot className="gap-6" asChild={true} variant="centered">
      <SectionRoot>
        <SectionHeader>
          <HeadingRoot level="h1" variant="h4">
            {title}
          </HeadingRoot>
        </SectionHeader>
        <SectionContent>
          <Card>
            <CardContent>
              <p>{trans("verify-email.instruction")}</p>
              <p>{trans("verify-email.prompt")}</p>
              <ButtonRoot asChild={true}>
                <Link href={route("verification.send")} method="post">
                  {trans("verify-email.send_again")}
                </Link>
              </ButtonRoot>
            </CardContent>
          </Card>
        </SectionContent>
      </SectionRoot>
    </ContainerRoot>
  );
}

export default VerifyEmail;
