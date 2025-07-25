import { Button } from "@narsil-cms/components/ui/button";
import { DialogClose } from "@narsil-cms/components/ui/dialog";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { Separator } from "@narsil-cms/components/ui/separator";
import { useLabels } from "@narsil-cms/components/ui/labels";
import TwoFactorForm from "./two-factor-form";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@narsil-cms/components/ui/section";
import type { LaravelForm } from "@narsil-cms/types/types";

type SecurityFormProps = {
  twoFactorForm: LaravelForm;
};

function SecurityForm({ twoFactorForm }: SecurityFormProps) {
  const { getLabel } = useLabels();

  return (
    <>
      <Section>
        <SectionHeader className="border-b">
          <SectionTitle level="h2">{getLabel("ui.security")}</SectionTitle>
        </SectionHeader>
        <SectionContent>
          <TwoFactorForm form={twoFactorForm} />
        </SectionContent>
      </Section>
      <Separator />
      <Section>
        <SectionHeader className="border-b">
          <SectionTitle level="h2">{getLabel("ui.sessions")}</SectionTitle>
        </SectionHeader>
        <SectionContent className="grid gap-4 text-sm">
          <p>{getLabel("sessions.sign_out_current_description")}</p>
          <DialogClose asChild={true}>
            <Button asChild={true} variant="outline">
              <Link
                method="delete"
                href={route("sessions.delete", {
                  type: "current",
                })}
              >
                {getLabel("sessions.sign_out_current")}
              </Link>
            </Button>
          </DialogClose>
          <Separator />
          <p>{getLabel("sessions.sign_out_elsewhere_description")}</p>
          <Button asChild={true} variant="outline">
            <Link
              method="delete"
              href={route("sessions.delete", {
                type: "others",
              })}
              preserveState={true}
            >
              {getLabel("sessions.sign_out_elsewhere")}
            </Link>
          </Button>
          <Separator />
          <p>{getLabel("sessions.sign_out_everywhere_description")}</p>
          <DialogClose asChild={true}>
            <Button asChild={true} variant="outline">
              <Link
                method="delete"
                href={route("sessions.delete", {
                  type: "all",
                })}
              >
                {getLabel("sessions.sign_out_everywhere")}
              </Link>
            </Button>
          </DialogClose>
        </SectionContent>
      </Section>
    </>
  );
}

export default SecurityForm;
