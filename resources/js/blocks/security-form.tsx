import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";

import TwoFactorForm from "@narsil-cms/blocks/two-factor-form";
import { DialogClose } from "@narsil-cms/components/dialog";
import { HeadingRoot } from "@narsil-cms/components/heading";
import { useLabels } from "@narsil-cms/components/labels";
import {
  SectionContent,
  SectionHeader,
  SectionRoot,
} from "@narsil-cms/components/section";
import { SeparatorRoot } from "@narsil-cms/components/separator";
import { type FormType } from "@narsil-cms/types";

import Button from "./button";

type SecurityFormProps = {
  twoFactorForm: FormType;
};

function SecurityForm({ twoFactorForm }: SecurityFormProps) {
  const { trans } = useLabels();

  return (
    <>
      <SectionRoot>
        <SectionHeader className="border-b">
          <HeadingRoot level="h2">{trans("ui.security")}</HeadingRoot>
        </SectionHeader>
        <SectionContent>
          <TwoFactorForm form={twoFactorForm} />
        </SectionContent>
      </SectionRoot>
      <SeparatorRoot />
      <SectionRoot>
        <SectionHeader className="border-b">
          <HeadingRoot level="h2">{trans("ui.sessions")}</HeadingRoot>
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
          <SeparatorRoot />
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
          <SeparatorRoot />
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
