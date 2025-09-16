import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";

import { Button, Heading, Separator } from "@narsil-cms/blocks";
import { DialogClose } from "@narsil-cms/components/dialog";
import { useLabels } from "@narsil-cms/components/labels";
import {
  SectionContent,
  SectionHeader,
  SectionRoot,
} from "@narsil-cms/components/section";
import { type FormType } from "@narsil-cms/types";

import TwoFactorForm from "./two-factor-form";

type SecurityFormProps = {
  twoFactorForm: FormType;
};

function SecurityForm({ twoFactorForm }: SecurityFormProps) {
  const { trans } = useLabels();

  return (
    <>
      <SectionRoot>
        <SectionHeader className="border-b">
          <Heading level="h2">{trans("ui.security")}</Heading>
        </SectionHeader>
        <SectionContent>
          <TwoFactorForm form={twoFactorForm} />
        </SectionContent>
      </SectionRoot>
      <Separator />
      <SectionRoot>
        <SectionHeader className="border-b">
          <Heading level="h2">{trans("ui.sessions")}</Heading>
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
      </SectionRoot>
    </>
  );
}

export default SecurityForm;
