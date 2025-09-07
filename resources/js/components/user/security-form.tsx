import { Button } from "@narsil-cms/components/button";
import { DialogClose } from "@narsil-cms/components/dialog";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { Separator } from "@narsil-cms/components/separator";
import { useLabels } from "@narsil-cms/components/labels";
import TwoFactorForm from "./two-factor-form";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@narsil-cms/components/section";
import type { FormType } from "@narsil-cms/types/forms";

type SecurityFormProps = {
  twoFactorForm: FormType;
};

function SecurityForm({ twoFactorForm }: SecurityFormProps) {
  const { trans } = useLabels();

  return (
    <>
      <Section>
        <SectionHeader className="border-b">
          <SectionTitle level="h2">{trans("ui.security")}</SectionTitle>
        </SectionHeader>
        <SectionContent>
          <TwoFactorForm form={twoFactorForm} />
        </SectionContent>
      </Section>
      <Separator />
      <Section>
        <SectionHeader className="border-b">
          <SectionTitle level="h2">{trans("ui.sessions")}</SectionTitle>
        </SectionHeader>
        <SectionContent className="grid gap-4 text-sm">
          <p>{trans("sessions.sign_out_current_description")}</p>
          <DialogClose asChild={true}>
            <Button asChild={true} variant="outline">
              <Link
                method="delete"
                href={route("sessions.delete", {
                  type: "current",
                })}
              >
                {trans("sessions.sign_out_current")}
              </Link>
            </Button>
          </DialogClose>
          <Separator />
          <p>{trans("sessions.sign_out_elsewhere_description")}</p>
          <Button asChild={true} variant="outline">
            <Link
              method="delete"
              href={route("sessions.delete", {
                type: "others",
              })}
              preserveState={true}
            >
              {trans("sessions.sign_out_elsewhere")}
            </Link>
          </Button>
          <Separator />
          <p>{trans("sessions.sign_out_everywhere_description")}</p>
          <DialogClose asChild={true}>
            <Button asChild={true} variant="outline">
              <Link
                method="delete"
                href={route("sessions.delete", {
                  type: "all",
                })}
              >
                {trans("sessions.sign_out_everywhere")}
              </Link>
            </Button>
          </DialogClose>
        </SectionContent>
      </Section>
    </>
  );
}

export default SecurityForm;
