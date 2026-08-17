import type { TemplateTab } from "@narsil-cms/types";
import { type IconName } from "@narsil-ui/registries/icons";
import { RoutesData } from "@narsil-ui/types";

export type FormType = {
  action: string;
  autoSave: boolean;
  defaultLanguage: string;
  description: string;
  id: string;
  languageOptions: SelectOption[];
  method: string;
  routes: RoutesData;
  submitIcon?: IconName;
  submitLabel: string;
  tabs: TemplateTab[];
  title: string;
};

export type GroupedSelectOption = {
  [key: string]: unknown;
  icon?: IconName;
  identifier: string;
  label: string | Record<string, string>;
  optionLabel: string;
  options: (GroupedSelectOption | SelectOption)[];
  optionValue: string;
  routes: RoutesData;
  value: unknown;
};

export type Revision = {
  id: number;
  revision: number;
  uuid: string;
};

export type SelectOption = {
  [key: string]: unknown;
  icon?: IconName;
  label: string | Record<string, string>;
  value: UniqueIdentifier;
};

export type UniqueIdentifier = string | number;
